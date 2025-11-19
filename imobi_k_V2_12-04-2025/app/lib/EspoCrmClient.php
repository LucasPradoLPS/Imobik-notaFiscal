<?php
/**
 * EspoCrmClient (minimal)
 * Consome API REST do EspoCRM via chave de API.
 * Você fará o HTML; aqui só backend.
 *
 * Requisitos para funcionar:
 * - Definir ESPOCRM_BASE_URL (ex: https://seu-espocrm.tld)
 * - Definir ESPOCRM_API_KEY (chave gerada no EspoCRM)
 * - Opcional ESPOCRM_AUTH_TYPE=apikey (padrão) ou bearer
 * - PHP com cURL habilitado.
 */
class EspoCrmClient
{
    private string $baseUrl;
    private string $apiKey;
    private string $authType;
    private int $connectTimeout;
    private int $requestTimeout;

    public function __construct($baseUrl = null, $apiKey = null, $authType = null)
    {
        $this->baseUrl = rtrim($baseUrl ?? getenv('ESPOCRM_BASE_URL') ?? '', '/');
        $this->apiKey  = $apiKey ?? getenv('ESPOCRM_API_KEY') ?? '';
        $envAuth = getenv('ESPOCRM_AUTH_TYPE');
        $this->authType = strtolower($authType ?? ($envAuth === false ? 'auto' : (string)$envAuth));
        if ($this->baseUrl === '' || $this->apiKey === '') {
            throw new InvalidArgumentException('Defina ESPOCRM_BASE_URL e ESPOCRM_API_KEY.');
        }
        $this->connectTimeout = max(1, (int)(getenv('ESPOCRM_CONNECT_TIMEOUT') ?: 3));
        $rt = (int)(getenv('ESPOCRM_TIMEOUT') ?: 8);
        $this->requestTimeout = $rt <= $this->connectTimeout ? $this->connectTimeout + 2 : $rt;
    }
    private function headers(): array
    {
        $h = ['Accept: application/json'];
        if ($this->authType === 'bearer') {
            $h[] = 'Authorization: Bearer ' . $this->apiKey;
        } elseif ($this->authType === 'apikey') {
            $h[] = 'X-Api-Key: ' . $this->apiKey;
            $h[] = 'Api-Key: ' . $this->apiKey; // compat
        } else { // auto: envia ambos para máxima compatibilidade
            $h[] = 'Authorization: Bearer ' . $this->apiKey;
            $h[] = 'X-Api-Key: ' . $this->apiKey;
            $h[] = 'Api-Key: ' . $this->apiKey;
        }
        return $h;
    }

    private function request(string $method, string $path, ?array $payload = null): array
    {
        $url = $this->baseUrl . '/' . ltrim($path, '/');

        // quick instrumentation for debugging internal dispatch decisions
        $dbg2 = __DIR__ . '/../../tmp/espocrm_request_debug.log';
        @file_put_contents($dbg2, date('c') . " | request-enter | method={$method} | path={$path} | payloadIsArray=" . (is_array($payload)?'1':'0') . "\n", FILE_APPEND);
        // If baseUrl points to the same host:port as this PHP process,
        // avoid making an HTTP request (which deadlocks with the PHP built-in server)
        // and attempt an internal dispatch to the local `api/v1` script if available.
        $parsed = parse_url($this->baseUrl);
        $baseHost = $parsed['host'] ?? null;
        $basePort = isset($parsed['port']) ? (int)$parsed['port'] : (isset($parsed['scheme']) && $parsed['scheme'] === 'https' ? 443 : 80);
        $serverHost = $_SERVER['SERVER_NAME'] ?? ($_SERVER['HTTP_HOST'] ?? null);
        $serverPort = isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : null;
        $sameHost = false;
        if ($serverPort && $basePort && $serverPort === $basePort) {
            $sameHost = true;
        }
        if ($serverHost && $baseHost && stripos($serverHost, $baseHost) !== false) {
            $sameHost = true;
        }
        $preferInternal = $sameHost;
        // also prefer internal dispatch for developer loopback addresses
        if (stripos($this->baseUrl, '127.0.0.1') !== false || stripos($this->baseUrl, 'localhost') !== false) {
            $preferInternal = true;
        }
        if ($baseHost && $preferInternal) {
            $internal = $this->internalRequest($method, $path, $payload);
            if ($internal !== null) {
                return $internal;
            }
            // if internal dispatch not possible, fall through to HTTP request
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->requestTimeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $headers = $this->headers();
        if ($payload !== null) {
            $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $headers[] = 'Content-Type: application/json';
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        $out = ['status' => $status];
        if ($err) { $out['error'] = $err; }
        // Try to decode JSON; strip potential UTF-8 BOM from start
        $rawStr = $raw ?: '';
        if (strncmp($rawStr, "\xEF\xBB\xBF", 3) === 0) {
            $rawStr = substr($rawStr, 3);
        }
        $decoded = json_decode($rawStr, true);
        if ($decoded !== null && json_last_error() === JSON_ERROR_NONE) {
            $out += $decoded;
        } else {
            $out['raw'] = $raw;
        }
        // logging opcional
        if ((getenv('ESPOCRM_LOG') ?? '') === '1') {
            $logFile = __DIR__ . '/../../tmp/espocrm_last.json';
            $record = [
                'timestamp' => date('c'),
                'method'    => $method,
                'url'       => $url,
                'payload'   => $payload,
                'headers'   => $headers,
                'status'    => $status,
                'error'     => $out['error'] ?? null,
                'response'  => isset($out['raw']) ? (strlen($out['raw'])>200?substr($out['raw'],0,200).'...':$out['raw']) : $decoded,
            ];
            @file_put_contents($logFile, json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
        return $out;
    }

    /**
     * Attempt to serve the request by including a local `api/v1/...` script.
     * Returns array like request() or null if internal dispatch is not possible.
     */
    private function internalRequest(string $method, string $path, ?array $payload = null): ?array
    {
        $p = ltrim($path, '/');
        if (stripos($p, 'api/v1/') !== 0) {
            return null;
        }
        // Map to local file: app root is two levels up from this file
        $rel = substr($p, strlen('api/v1/'));
        $parts = explode('?', $rel, 2);
        $scriptPath = __DIR__ . '/../../api/v1/' . trim($parts[0], '/') . '/index.php';
        // fallback to repo-level mock_server if present (developer convenience)
        $mockPath = __DIR__ . '/../../../mock_server/api/v1/' . trim($parts[0], '/') . '/index.php';
        if (!file_exists($scriptPath)) {
            // If requested path includes an id segment like Contact/ID, but there is an index.php
            // under Contact, map the id into $_GET['id'] and include Contact/index.php.
            $segments = explode('/', trim($parts[0], '/'));
            if (count($segments) > 1) {
                $entityDir = $segments[0];
                $rest = implode('/', array_slice($segments, 1));
                $maybeIndex = __DIR__ . '/../../api/v1/' . $entityDir . '/index.php';
                $maybeMockIndex = __DIR__ . '/../../../mock_server/api/v1/' . $entityDir . '/index.php';
                if (file_exists($maybeIndex)) {
                    $scriptPath = $maybeIndex;
                    // expose id to the included script
                    $_GET['id'] = $rest;
                } elseif (file_exists($maybeMockIndex)) {
                    $scriptPath = $maybeMockIndex;
                    $_GET['id'] = $rest;
                } else {
                    // fallback to original mockPath (which may include deeper segments)
                    if (file_exists($mockPath)) {
                        $scriptPath = $mockPath;
                    } else {
                        return null;
                    }
                }
            } else {
                if (file_exists($mockPath)) {
                    $scriptPath = $mockPath;
                } else {
                    return null;
                }
            }
        }
        // Backup global state we will modify
        $backupGet = $_GET;
        $backupPost = $_POST;
        $backupServer = $_SERVER;
        $backupInput = null;
        // Apply query string if present
        if (isset($parts[1])) {
            parse_str($parts[1], $qs);
            $_GET = $qs + $_GET;
        }
        // For payloads, populate $_POST for simple cases. If payload was not supplied
        // (null) but the outer HTTP request had a body, attempt to capture and use it.
        $rawOuterInput = @file_get_contents('php://input');
        // Defensive fallback: if there's a raw request body, write it to a temp file
        // and expose its path to included scripts via $_SERVER so mocks can read it
        // when php://input appears empty (issue with PHP built-in server dispatch).
        if ($rawOuterInput && strlen(trim($rawOuterInput)) > 0) {
            $payloadDir = __DIR__ . '/../../tmp/espocrm_internal_payloads';
            @mkdir($payloadDir, 0755, true);
            $fname = $payloadDir . '/payload_' . date('YmdHis') . '_' . substr(md5(uniqid('', true)), 0, 8) . '.json';
            @file_put_contents($fname, $rawOuterInput);
            // expose to included scripts
            $_SERVER['ESPCRM_INTERNAL_PAYLOAD_FILE'] = $fname;
            // log to internal debug file for correlation
            $dbgFile2 = __DIR__ . '/../../tmp/espocrm_internal_debug.log';
            @file_put_contents($dbgFile2, date('c') . " | internal-payload-file: {$fname} | len=" . strlen($rawOuterInput) . "\n", FILE_APPEND);
        }
        if (($method === 'POST' || $method === 'PUT')) {
            if (is_array($payload)) {
                // Do not merge with existing $_POST to avoid leaking outer request params
                $_POST = $payload;
            } else {
                // Try to parse raw input JSON if available
                if ($rawOuterInput && strlen(trim($rawOuterInput)) > 0) {
                    $decodedOuter = json_decode($rawOuterInput, true);
                    if (is_array($decodedOuter)) {
                        $_POST = $decodedOuter;
                        // reflect back into $payload for diagnostics/return
                        $payload = $decodedOuter;
                    }
                }
            }
        }
        // Ensure SERVER vars
        $_SERVER['REQUEST_METHOD'] = $method;
        // Write a small debug trace so we can see which script was included and raw input
        $dbgFile = __DIR__ . '/../../tmp/espocrm_internal_debug.log';
        $pl = is_array($payload) ? json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) : var_export($payload, true);
        $rawSnippet = $rawOuterInput ? (strlen($rawOuterInput) > 400 ? substr($rawOuterInput,0,400) . '...' : $rawOuterInput) : '';
        @file_put_contents($dbgFile, date('c') . " | include: {$scriptPath} | method: {$method} | payload: {$pl} | rawInputLen=" . strlen($rawOuterInput) . " | rawInput=" . str_replace("\n", '\\n', $rawSnippet) . "\n", FILE_APPEND);

        // Dump server/post state just before include for diagnostics
        try {
            $dump = [
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'] ?? null,
                'QUERY_STRING' => $_SERVER['QUERY_STRING'] ?? null,
                'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? null,
                'GET' => $_GET,
                'POST' => $_POST,
            ];
            @file_put_contents($dbgFile, date('c') . " | pre-include-dump: " . str_replace("\n", '\\n', var_export($dump, true)) . "\n", FILE_APPEND);
        } catch (Throwable $e) {
            // ignore
        }

        // Capture output
        ob_start();
        try {
            include $scriptPath;
        } catch (Throwable $e) {
            ob_end_clean();
            // restore
            $_GET = $backupGet; $_POST = $backupPost; $_SERVER = $backupServer;
            return [ 'status' => 500, 'error' => $e->getMessage() ];
        }
        $raw = (string)ob_get_clean();
        // restore globals
        $_GET = $backupGet; $_POST = $backupPost; $_SERVER = $backupServer;
        // Optional logging for internal dispatch (mirror of HTTP logging)
        if ((getenv('ESPOCRM_LOG') ?? '') === '1') {
            $logFile = __DIR__ . '/../../tmp/espocrm_last.json';
            $record = [
                'timestamp' => date('c'),
                'method'    => $method,
                'url'       => $this->baseUrl . '/' . ltrim($path, '/'),
                'payload'   => $payload,
                'internal'  => true,
                'response'  => (strlen($raw)>200?substr($raw,0,200).'...':$raw),
            ];
            @file_put_contents($logFile, json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
        $decoded = json_decode($raw, true);
        $status = 200;
        $out = ['status' => $status];
        if ($decoded !== null && json_last_error() === JSON_ERROR_NONE) {
            $out += $decoded;
        } else {
            $out['raw'] = $raw;
        }
        return $out;
    }

    public function health(): array
    {
        $r = $this->request('GET', 'api/v1/metadata');
        return [
            'ok' => ($r['status'] ?? 0) >= 200 && ($r['status'] ?? 0) < 500,
            'status' => $r['status'] ?? 0,
            'error' => $r['error'] ?? null
        ];
    }

    // Compatibility wrappers: older code expects simple get/post/put/delete methods
    public function get(string $path, ?array $params = null): array
    {
        if (is_array($params) && count($params) > 0) {
            $query = http_build_query($params);
            $path = rtrim($path, '?') . (strpos($path, '?') === false ? '?' : '&') . $query;
        }
        return $this->request('GET', ltrim($path, '/'));
    }

    public function post(string $path, ?array $payload = null): array
    {
        return $this->request('POST', ltrim($path, '/'), $payload);
    }

    public function put(string $path, ?array $payload = null): array
    {
        return $this->request('PUT', ltrim($path, '/'), $payload);
    }

    // Note: kept below a flexible `delete` implementation that supports both
    // calls like delete('Entity', 'id') and delete('/api/v1/Entity/id')

    public function list(string $entity, int $maxSize = 20, int $offset = 0): array
    {
        return $this->request('GET', 'api/v1/' . rawurlencode($entity) . '?maxSize=' . $maxSize . '&offset=' . $offset);
    }
    public function getRecord(string $entity, string $id): array { return $this->request('GET', 'api/v1/' . rawurlencode($entity) . '/' . rawurlencode($id)); }
    public function create(string $entity, array $data): array { return $this->request('POST', 'api/v1/' . rawurlencode($entity), $data); }
    public function update(string $entity, string $id, array $data): array { return $this->request('PUT', 'api/v1/' . rawurlencode($entity) . '/' . rawurlencode($id), $data); }
    public function delete(...$args): array
    {
        if (count($args) === 2 && is_string($args[0]) && is_string($args[1])) {
            return $this->request('DELETE', 'api/v1/' . rawurlencode($args[0]) . '/' . rawurlencode($args[1]));
        }
        if (count($args) === 1 && is_string($args[0])) {
            return $this->request('DELETE', ltrim($args[0], '/'));
        }
        throw new InvalidArgumentException('Invalid arguments for EspoCrmClient::delete()');
    }

    /**
     * Fallback to support older callers that call ->get()/->post()/->put()/->delete()
     * even if a different client implementation is loaded. This magic handler
     * delegates common REST verbs to the internal request() implementation.
     */
    public function __call($name, $arguments)
    {
        $verb = strtoupper($name);
        if (in_array($verb, ['GET', 'POST', 'PUT', 'DELETE'], true)) {
            $path = isset($arguments[0]) ? (string)$arguments[0] : '';
            $payload = $arguments[1] ?? null;
            return $this->request($verb, ltrim($path, '/'), is_array($payload) ? $payload : null);
        }
        throw new BadMethodCallException("Method {$name} does not exist on " . __CLASS__);
    }
}
