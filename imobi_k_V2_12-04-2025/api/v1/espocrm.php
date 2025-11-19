<?php
/**
 * Minimal REST proxy for EspoCRM resources.
 * Usage (examples):
 *  GET  /api/v1/espocrm.php?resource=contacts
 *  POST /api/v1/espocrm.php?resource=contacts  (json body)
 *  PUT  /api/v1/espocrm.php?resource=contacts&id=<id> (json body)
 *  DELETE /api/v1/espocrm.php?resource=contacts&id=<id>
 *
 * The proxy reads the API key from environment var `ESPOCRM_API_KEY` or from
 * `app/config/espocrm.php` (if present). The front-end is the user's responsibility.
 */
header('Content-Type: application/json; charset=utf-8');

$root = realpath(__DIR__ . '/../../');
// Load .env (optional) to support local development without system-wide env vars
$dotenvPath = $root . '/.env';
if (file_exists($dotenvPath) && is_readable($dotenvPath)) {
    $lines = file($dotenvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // strip UTF-8 BOM if present (common on Windows editors)
            if (strpos($line, "\xEF\xBB\xBF") === 0) { $line = substr($line, 3); }
            if (strpos(trim($line ?? ''), '#') === 0) { continue; }
        $pos = strpos($line, '=');
        if ($pos === false) { continue; }
        $key = trim(substr($line, 0, $pos) ?? '');
        $val = trim(substr($line, $pos + 1) ?? '');
        // strip quotes
        if ((str_starts_with($val, '"') && str_ends_with($val, '"')) || (str_starts_with($val, "'") && str_ends_with($val, "'"))) {
            $val = substr($val, 1, -1);
        }
        if ($key !== '') {
            putenv($key . '=' . $val);
            $_ENV[$key] = $val;
            $_SERVER[$key] = $val;
        }
    }
}
// try to include client from app/lib
$clientPath = $root . '/app/lib/EspoCrmClient.php';
if (file_exists($clientPath)) {
    require_once $clientPath;
} else {
    http_response_code(500);
    echo json_encode(['error' => 'EspoCrmClient missing on server']);
    exit;
}

$cfgFile = $root . '/app/config/espocrm.php';
$baseUrl = getenv('ESPOCRM_BASE_URL') ?: null;
$apiKey  = getenv('ESPOCRM_API_KEY') ?: null;
$authType = getenv('ESPOCRM_AUTH_TYPE') ?: 'apikey';
if (file_exists($cfgFile)) {
    $cfg = include $cfgFile;
    $baseUrl = $cfg['base_url'] ?? $baseUrl;
    $apiKey  = $cfg['api_key']  ?? $apiKey;
    $authType = $cfg['auth_type'] ?? $authType;
}

// Helper to print upstream response robustly
function espocrm_respond(array $res): void {
    $body = $res['body'] ?? null;
    $raw  = $res['raw']  ?? '';
    $info = $res['info'] ?? [];
    if (is_array($body) || is_object($body)) {
        echo json_encode($body);
        return;
    }
    // try to salvage raw JSON (strip BOM and trim)
    if (is_string($raw) && $raw !== '') {
        $raw2 = $raw;
        if (strpos($raw2 ?? '', "\xEF\xBB\xBF") === 0) { $raw2 = substr($raw2, 3); }
        $raw2 = trim($raw2 ?? '');
        $decoded = json_decode($raw2, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            echo json_encode($decoded);
            return;
        }
        http_response_code(502);
        echo json_encode([
            'error' => 'upstream invalid json',
            'message' => json_last_error_msg(),
            'snippet' => substr($raw2, 0, 300),
            'http_code' => $info['http_code'] ?? null
        ]);
        return;
    }
    http_response_code(502);
    echo json_encode(['error' => 'upstream empty response', 'http_code' => $info['http_code'] ?? null]);
}

// Fallback GET using same approach as diagnostic
function espocrm_fetch_fallback(string $baseUrl, string $path, array $headers): array {
    $url = rtrim($baseUrl,'/') . '/' . ltrim($path,'/');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_TIMEOUT, 6);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $resp = curl_exec($ch);
    $info = curl_getinfo($ch);
    $err  = curl_error($ch);
    $errno = curl_errno($ch);
    curl_close($ch);
    // Return raw even on errors to allow salvage
    return ['body' => null, 'raw' => (string)$resp, 'info' => $info, 'error' => $err, 'errno' => $errno];
}

// Quick connectivity pre-check to fail fast instead of long timeouts
if ($baseUrl) {
    $parsed = @parse_url($baseUrl);
    if ($parsed !== false && isset($parsed['host'])) {
        $host = $parsed['host'];
        $port = $parsed['port'] ?? (($parsed['scheme'] ?? 'http') === 'https' ? 443 : 80);
        $sock = @fsockopen($host, $port, $errno, $errstr, 1.0); // 1s connect timeout
        if (! $sock) {
            http_response_code(503);
            echo json_encode([
                'error' => 'EspoCRM unreachable',
                'message' => 'Host/porta inacessível: ' . $host . ':' . $port,
                'errno' => $errno,
                'errstr' => $errstr,
                'base_url' => $baseUrl
            ]);
            exit;
        }
        fclose($sock);
    }
}

// Health check endpoint: /api/v1/espocrm.php?health=1
if (isset($_GET['health'])) {
    $status = [
        'base_url' => $baseUrl,
        'api_key_present' => !empty($apiKey),
        'auth_type' => $authType,
        'timestamp' => date('c')
    ];
    // Attempt a very quick socket re-check
    $reachable = true; $errno2 = null; $errstr2 = null;
    if ($baseUrl) {
        $parsed2 = @parse_url($baseUrl);
        if ($parsed2 !== false && isset($parsed2['host'])) {
            $host2 = $parsed2['host'];
            $port2 = $parsed2['port'] ?? (($parsed2['scheme'] ?? 'http') === 'https' ? 443 : 80);
            $sock2 = @fsockopen($host2, $port2, $errno2, $errstr2, 1.0);
            if (! $sock2) { $reachable = false; } else { fclose($sock2); }
            $status['reachable'] = $reachable;
            $status['host'] = $host2;
            $status['port'] = $port2;
            if (!$reachable) {
                $status['errno'] = $errno2;
                $status['errstr'] = $errstr2;
            }
        }
    }
    echo json_encode($status);
    exit;
}

// Diagnostic endpoint: performs a lightweight GET to Contact with very short timeouts
if (isset($_GET['diagnostic'])) {
    $result = [
        'base_url' => $baseUrl,
        'auth_type' => $authType,
        'api_key_present' => !empty($apiKey),
    ];
    try {
        // manual curl with short timeouts
        $urlTest = rtrim($baseUrl,'/') . '/api/v1/Contact';
        $ch = curl_init($urlTest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        $headers = ['Accept: application/json'];
        if (!empty($apiKey)) {
            if ($authType === 'bearer') {
                $headers[] = 'Authorization: Bearer ' . $apiKey;
            } else {
                $headers[] = 'X-API-KEY: ' . $apiKey;
                $headers[] = 'Api-Key: ' . $apiKey;
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $start = microtime(true);
        $resp = curl_exec($ch);
        $info = curl_getinfo($ch);
        $err  = curl_error($ch);
        $errno = curl_errno($ch);
        $duration = round((microtime(true)-$start)*1000,2);
        curl_close($ch);
        $result['duration_ms'] = $duration;
        $result['curl_info'] = $info;
        if ($resp === false) {
            $result['error'] = 'curl_error';
            $result['errno'] = $errno;
            $result['errstr'] = $err;
        } else {
            $decoded = json_decode($resp, true);
            $result['response_snippet'] = substr($resp,0,300);
            $result['decoded_type'] = gettype($decoded);
            $result['http_code'] = $info['http_code'] ?? null;
        }
    } catch (Throwable $e) {
        $result['exception'] = $e->getMessage();
    }
    echo json_encode($result);
    exit;
}

try {
    $client = new EspoCrmClient($baseUrl, $apiKey, $authType);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

$resource = strtolower($_GET['resource'] ?? ($_GET['r'] ?? ''));
$id = $_GET['id'] ?? null;
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

try {
    switch ($resource) {
        case 'contacts':
            if ($method === 'GET') {
                $params = $_GET;
                unset($params['resource'], $params['r'], $params['id']);
                $res = $client->get('/api/v1/Contact', $params);
                if ((($res['info']['http_code'] ?? 0) === 401) || (empty($res['body']) && empty($res['raw']))) {
                    // build headers similar to diagnostic for fallback
                    $headers = ['Accept: application/json'];
                    if (!empty($apiKey)) {
                        if ($authType === 'bearer') { $headers[] = 'Authorization: Bearer ' . $apiKey; }
                        else { $headers[] = 'X-API-KEY: ' . $apiKey; $headers[] = 'Api-Key: ' . $apiKey; }
                    }
                    $res = espocrm_fetch_fallback($baseUrl, '/api/v1/Contact', $headers);
                }
                espocrm_respond($res);
                exit;
            }
            if ($method === 'POST') {
                $res = $client->post('/api/v1/Contact', $input ?? []);
                espocrm_respond($res); exit;
            }
            if (in_array($method, ['PUT','PATCH'])) {
                if (empty($id)) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; }
                $res = $client->put('/api/v1/Contact/' . rawurlencode($id), $input ?? []);
                espocrm_respond($res); exit;
            }
            if ($method === 'DELETE') {
                if (empty($id)) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; }
                $res = $client->delete('/api/v1/Contact/' . rawurlencode($id));
                espocrm_respond($res); exit;
            }
            break;
        case 'leads':
            if ($method === 'GET') {
                $params = $_GET; unset($params['resource'], $params['r'], $params['id']);
                $res = $client->get('/api/v1/Lead', $params);
                if ((($res['info']['http_code'] ?? 0) === 401) || (empty($res['body']) && empty($res['raw']))) {
                    $headers = ['Accept: application/json'];
                    if (!empty($apiKey)) { if ($authType === 'bearer') { $headers[] = 'Authorization: Bearer ' . $apiKey; } else { $headers[] = 'X-API-KEY: ' . $apiKey; $headers[] = 'Api-Key: ' . $apiKey; } }
                    $res = espocrm_fetch_fallback($baseUrl, '/api/v1/Lead', $headers);
                }
                espocrm_respond($res); exit;
            }
            if ($method === 'POST') { $res = $client->post('/api/v1/Lead', $input ?? []); espocrm_respond($res); exit; }
            if (in_array($method, ['PUT','PATCH'])) { if (empty($id)) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; } $res = $client->put('/api/v1/Lead/' . rawurlencode($id), $input ?? []); espocrm_respond($res); exit; }
            if ($method === 'DELETE') { if (empty($id)) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; } $res = $client->delete('/api/v1/Lead/' . rawurlencode($id)); espocrm_respond($res); exit; }
            break;
        case 'accounts':
            if ($method === 'GET') {
                $params = $_GET; unset($params['resource'], $params['r'], $params['id']);
                $res = $client->get('/api/v1/Account', $params);
                if ((($res['info']['http_code'] ?? 0) === 401) || (empty($res['body']) && empty($res['raw']))) {
                    $headers = ['Accept: application/json'];
                    if (!empty($apiKey)) { if ($authType === 'bearer') { $headers[] = 'Authorization: Bearer ' . $apiKey; } else { $headers[] = 'X-API-KEY: ' . $apiKey; $headers[] = 'Api-Key: ' . $apiKey; } }
                    $res = espocrm_fetch_fallback($baseUrl, '/api/v1/Account', $headers);
                }
                espocrm_respond($res); exit;
            }
            if ($method === 'POST') { $res = $client->post('/api/v1/Account', $input ?? []); espocrm_respond($res); exit; }
            if (in_array($method, ['PUT','PATCH'])) { if (empty($id)) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; } $res = $client->put('/api/v1/Account/' . rawurlencode($id), $input ?? []); espocrm_respond($res); exit; }
            if ($method === 'DELETE') { if (empty($id)) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; } $res = $client->delete('/api/v1/Account/' . rawurlencode($id)); espocrm_respond($res); exit; }
            break;
        case 'user':
            if ($method === 'GET') {
                // current authenticated user info
                $res = $client->get('/api/v1/App/user');
                if ((($res['info']['http_code'] ?? 0) === 401) || (empty($res['body']) && empty($res['raw']))) {
                    $headers = ['Accept: application/json'];
                    if (!empty($apiKey)) { if ($authType === 'bearer') { $headers[] = 'Authorization: Bearer ' . $apiKey; } else { $headers[] = 'X-API-KEY: ' . $apiKey; $headers[] = 'Api-Key: ' . $apiKey; } }
                    $res = espocrm_fetch_fallback($baseUrl, '/api/v1/App/user', $headers);
                }
                espocrm_respond($res); exit;
            }
            http_response_code(405); echo json_encode(['error'=>'method not allowed']); exit;
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'resource not found, use resource=contacts|leads|accounts|user']);
            exit;
    }
} catch (Exception $e) {
    http_response_code(502);
    echo json_encode(['error' => 'upstream error', 'message' => $e->getMessage()]);
    exit;
}
