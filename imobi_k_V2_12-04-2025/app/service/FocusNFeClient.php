<?php
/**
 * FocusNFeClient - cliente simples para consumir API Focus NFe via cURL
 *
 * Observações:
 * - Ajuste headers e endpoints conforme a versão da API da Focus (documentação oficial).
 * - Este cliente usa token Bearer; se a Focus usar outro esquema, adapte.
 */

class FocusNFeClient
{
    private $baseUrl;
    private $token;
    private $timeout;
    private $env;

    public function __construct(array $config)
    {
        // Support both old flat config and new multi-environment config
        $cfg = $config;
        if (isset($config['environments']) && is_array($config['environments'])) {
            $env = $config['environment'] ?? 'sandbox';
            if (!isset($config['environments'][$env])) {
                throw new InvalidArgumentException('FocusNFeClient: ambiente desconhecido no config: ' . $env);
            }
            $cfg = $config['environments'][$env];
            // allow timeout at root level
            $this->timeout = (int)($config['timeout'] ?? 30);
            $this->env = $env;
        } else {
            $this->timeout = (int)($config['timeout'] ?? 30);
            $this->env = $config['environment'] ?? 'sandbox';
        }

        $this->baseUrl = rtrim($cfg['base_url'] ?? '', '/');
        $this->token = $cfg['token'] ?? '';

        if (empty($this->baseUrl) || empty($this->token)) {
            throw new InvalidArgumentException('FocusNFeClient: base_url e token são obrigatórios no config.');
        }
    }

    private function request(string $method, string $path, $body = null, array $extraHeaders = [])
    {
        $url = $this->baseUrl . $path;

        // Check DNS resolution before attempting cURL to provide a clearer error message
        $host = parse_url($url, PHP_URL_HOST);
        // Allow skipping DNS pre-check via environment variable for local development or networks
        // Set FOCUS_NFE_SKIP_DNS_CHECK=1 to bypass the dns_get_record call
        $skipDns = false;
        $envSkip = getenv('FOCUS_NFE_SKIP_DNS_CHECK');
        if ($envSkip !== false && $envSkip !== null && $envSkip !== '') {
            $skipDns = in_array(strtolower($envSkip), ['1','true','yes','on'], true);
        }
        if ($host) {
            // strip brackets if IPv6 literal provided (e.g. [::1])
            $host_trim = trim($host, "[]");

            // Skip DNS pre-check for loopback/local addresses (localhost or common IPs)
            $lower = strtolower($host_trim);
            $skip_hosts = ['localhost', '127.0.0.1', '::1'];

            // Also skip if host is an IP literal (IPv4 or IPv6)
            $is_ip = filter_var($host_trim, FILTER_VALIDATE_IP) !== false;

            if (!in_array($lower, $skip_hosts) && !$is_ip) {
                if (!$skipDns) {
                    // dns_get_record returns false on failure or empty array when not found
                    $records = @dns_get_record($host_trim, DNS_A + DNS_AAAA + DNS_CNAME);
                    if ($records === false || count($records) === 0) {
                        throw new RuntimeException("DNS resolution failed for host: {$host_trim}.\n" .
                            "Possible causes:\n" .
                            " - The configured hostname is incorrect or no longer exists.\n" .
                            " - Your machine/network cannot resolve external DNS.\n" .
                            "O que você pode fazer:\n" .
                            " - Verifique o endpoint de homolog/produção com a documentação da Focus NFe.\n" .
                            " - Override a URL via variáveis de ambiente: FOCUS_NFE_BASE_URL_HOMOLOG ou FOCUS_NFE_BASE_URL.\n" .
                            " - Para desenvolvimento local, aponte o config para um mock local (ex.: http://localhost:8081).\n" .
                            "Exemplo (PowerShell, temporário): \$env:FOCUS_NFE_BASE_URL_HOMOLOG='http://localhost:8081'\n");
                    }
                } else {
                    // Skipping DNS pre-check as requested by environment (useful for local mocks)
                }
            }
        }

        // allow caller to override Authorization header by passing it in extraHeaders
        $hasAuthOverride = false;
        foreach ($extraHeaders as $h) {
            if (stripos($h, 'authorization:') === 0) { $hasAuthOverride = true; break; }
        }

        $defaultHeaders = ['Accept: application/json'];
        if (!$hasAuthOverride) {
            $defaultHeaders[] = 'Authorization: Bearer ' . $this->token;
        }

        $headers = array_merge($defaultHeaders, $extraHeaders);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

        // If caller requested Basic via an Authorization header, prefer setting CURLOPT_USERPWD
        // (some servers behave better when cURL sends Basic via CURLOPT_USERPWD)
        foreach ($headers as $i => $h) {
            if (stripos($h, 'authorization: basic') === 0) {
                // set user:pass using token as username
                curl_setopt($ch, CURLOPT_USERPWD, ($this->token ?? '') . ':');
                // remove the explicit header to avoid duplicates
                unset($headers[$i]);
                break;
            }
        }

        // If body provided and is array, encode JSON
        if ($body !== null) {
            if (is_array($body) || is_object($body)) {
                $payload = json_encode($body);
                $headers[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            } else {
                // raw string (e.g., XML)
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                // leave content-type to caller via extraHeaders
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // SSL options: if you need to trust self-signed in local dev, set FALSE (not recommended)
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $err = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($errno) {
            throw new RuntimeException('cURL error: ' . $err, $errno);
        }

        // Try decode JSON, fallback to raw
        $decoded = null;
        $contentType = null;
        // note: we didn't capture response headers; assume JSON if starts with { or [
        $trim = ltrim($response ?? '');
        if (strlen($trim) > 0 && ($trim[0] === '{' || $trim[0] === '[')) {
            $decoded = json_decode($response, true);
        }

        return [
            'status' => $code,
            'body' => $response,
            'json' => $decoded,
        ];
    }

    // Exemplo: enviar XML de nota fiscal (NF-e) para emissão
    // $xmlString: conteúdo XML da NF-e (string)
    // Retorna array com keys: status, body, json
    public function sendInvoiceXml(string $xmlString, ?string $ref = null)
    {
        // Try smarter sending depending on environment and API expectations.
        // For modern Focus endpoints (v2), the API expects JSON with XML in a field (observed in homolog returning JSON parse error on raw XML).
        // Strategy:
        // 1) If env is homolog or production (or baseUrl already contains '/v2'), try POST /v2/nfe with JSON body {"xml": "..."} first.
        // 2) If that fails (non-2xx), fallback to POST /nfe with raw XML (legacy behaviour).

        $tried = [];
        $baseContainsV2 = (strpos($this->baseUrl, '/v2') !== false);

        // ensure we always have a reference id for v2 payloads
        // generate a safe ref (no dots) acceptable to Focus API
        if (!empty($ref)) {
            $refToSend = $ref;
        } else {
            try {
                $refToSend = 'ref' . bin2hex(random_bytes(8));
            } catch (Exception $e) {
                // fallback
                $refToSend = preg_replace('/[^A-Za-z0-9_\-]/', '', uniqid('ref', true));
            }
        }

        // Always attempt the modern v2 JSON endpoint first; many Focus installations expose /v2/nfe
        $path = '/v2/nfe';
        // send as JSON wrapper (include ref because some Focus endpoints require it)
        $res = $this->request('POST', $path, ['xml' => $xmlString, 'ref' => $refToSend], ['Content-Type: application/json']);
        // if successful, return
        if ($res['status'] >= 200 && $res['status'] < 300) {
            return $res;
        }
        // Try Basic auth (token as username) as a second attempt if v2 didn't return success.
        // Some Focus homolog instances respond 404 or 400 to Bearer and require Basic explicitly.
        $basic = 'Authorization: Basic ' . base64_encode(($this->token ?? '') . ':');
        $res2 = $this->request('POST', $path, ['xml' => $xmlString, 'ref' => $refToSend], ['Content-Type: application/json', $basic]);
        // if Basic attempt returned success, return it; otherwise return the Basic response
        if ($res2['status'] >= 200 && $res2['status'] < 300) {
            return $res2;
        }
        // return the informative v2 response (even if 4xx) so caller can see provider error messages
        return $res2;
        $tried[] = [$path . ' (basic)', $res2];
        $tried[] = [$path, $res];

        // fallback to legacy raw XML POST
        $path = '/nfe';
        $res = $this->request('POST', $path, $xmlString, ['Content-Type: application/xml']);
        // if returned 400 and message indicates JSON expected, try JSON wrapper to /v2/nfe as a last attempt
        $body = $res['body'] ?? '';
        if (($res['status'] >= 400 && $res['status'] < 500) && preg_match('/JSON/i', $body)) {
            $path2 = '/v2/nfe';
            $res2 = $this->request('POST', $path2, ['xml' => $xmlString, 'ref' => $refToSend], ['Content-Type: application/json']);
            return $res2;
        }

        return $res;
    }

    // Se a API aceita multipart/form-data para upload do arquivo XML
    public function sendInvoiceFile(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new InvalidArgumentException('Arquivo não encontrado: ' . $filePath);
        }

        $path = '/nfe/file'; // ajuste conforme doc

        // build multipart body via CURLFile
        $cfile = new CURLFile($filePath);
        $boundary = '----FocusBoundary' . md5((string)microtime(true));
        $headers = [
            'Content-Type: multipart/form-data; boundary=' . $boundary
        ];

        // Use request but with raw curl since our request helper assumes JSON/string bodies
        $url = $this->baseUrl . $path;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => $cfile]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
            'Authorization: Bearer ' . $this->token,
            'Accept: application/json'
        ], $headers));
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $err = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($errno) {
            throw new RuntimeException('cURL error: ' . $err, $errno);
        }
        $decoded = null;
        $trim = ltrim($response ?? '');
        if (strlen($trim) > 0 && ($trim[0] === '{' || $trim[0] === '[')) {
            $decoded = json_decode($response, true);
        }
        return ['status' => $code, 'body' => $response, 'json' => $decoded];
    }

    // Consultar status por chave (número da nota)
    public function getStatusByKey(string $chave)
    {
        $path = '/nfe/' . rawurlencode($chave) . '/status';
        return $this->request('GET', $path);
    }

    // Cancelar nota (exemplo)
    public function cancel(string $chave, string $justificativa)
    {
        $path = '/nfe/' . rawurlencode($chave) . '/cancel';
        $body = ['justificativa' => $justificativa];
        return $this->request('POST', $path, $body);
    }

    // Obter PDF/DANFE (se API oferecer). Retorna raw binary no body
    public function getDanfePdf(string $chave)
    {
        $path = '/nfe/' . rawurlencode($chave) . '/pdf';
        $res = $this->request('GET', $path, null, ['Accept: application/pdf']);
        return $res;
    }

    // --- Novos métodos para endpoints /v2/nfe e auxiliares ---

    // GET /v2/nfe/{ref} - consulta a nota pela referência
    public function getByReference(string $ref)
    {
        $path = '/v2/nfe/' . rawurlencode($ref);
        return $this->request('GET', $path);
    }

    // DELETE /v2/nfe/{ref} - cancela uma nota pela referência
    public function deleteByReference(string $ref)
    {
        $path = '/v2/nfe/' . rawurlencode($ref);
        return $this->request('DELETE', $path);
    }

    // POST /v2/nfe/{ref}/carta_correcao - cria carta de correção
    // $payload should be an associative array following provider spec (e.g. ['texto' => '...'])
    public function createCartaCorrecao(string $ref, array $payload)
    {
        $path = '/v2/nfe/' . rawurlencode($ref) . '/carta_correcao';
        return $this->request('POST', $path, $payload, ['Content-Type: application/json']);
    }

    // POST /v2/nfe/{ref}/ator_interessado - adiciona ator interessado
    public function addAtorInteressado(string $ref, array $payload)
    {
        $path = '/v2/nfe/' . rawurlencode($ref) . '/ator_interessado';
        return $this->request('POST', $path, $payload, ['Content-Type: application/json']);
    }

    // POST /v2/nfe/{ref}/insucesso_entrega - registra insucesso na entrega
    public function markInsucessoEntrega(string $ref, array $payload)
    {
        $path = '/v2/nfe/' . rawurlencode($ref) . '/insucesso_entrega';
        return $this->request('POST', $path, $payload, ['Content-Type: application/json']);
    }

    // DELETE /v2/nfe/{ref}/insucesso_entrega - cancela evento de insucesso
    public function deleteInsucessoEntrega(string $ref)
    {
        $path = '/v2/nfe/' . rawurlencode($ref) . '/insucesso_entrega';
        return $this->request('DELETE', $path);
    }

    // POST /v2/nfe/{ref}/email - envia email com cópia da nota
    // $payload e.g. ['to' => 'email@exemplo.com', 'subject' => '...', 'message' => '...']
    public function sendEmailByReference(string $ref, array $payload)
    {
        $path = '/v2/nfe/' . rawurlencode($ref) . '/email';
        return $this->request('POST', $path, $payload, ['Content-Type: application/json']);
    }

    // POST /v2/nfe/inutilizacao - inutiliza numeração
    // $payload should contain required fields (e.g. {"serie":..., "nNFIni":..., "nNFFin":..., "justificativa":...})
    public function inutilizacao(array $payload)
    {
        $path = '/v2/nfe/inutilizacao';
        return $this->request('POST', $path, $payload, ['Content-Type: application/json']);
    }

    // GET /v2/nfe/inutilizacoes - lista inutilizações
    public function listInutilizacoes(array $query = [])
    {
        $qs = '';
        if (!empty($query)) {
            $qs = '?' . http_build_query($query);
        }
        $path = '/v2/nfe/inutilizacoes' . $qs;
        return $this->request('GET', $path);
    }

    // POST /v2/nfe/importacao?ref=REFERENCIA - importa um XML como nota
    // $xmlString is raw XML string
    public function importacaoFromXml(string $ref, string $xmlString)
    {
        $path = '/v2/nfe/importacao?ref=' . rawurlencode($ref);
        // Some providers expect multipart or JSON; try JSON wrapper first
        $res = $this->request('POST', $path, ['xml' => $xmlString, 'ref' => $ref], ['Content-Type: application/json']);
        if ($res['status'] >= 200 && $res['status'] < 300) {
            return $res;
        }
        // fallback to raw XML post
        return $this->request('POST', $path, $xmlString, ['Content-Type: application/xml']);
    }

    // POST /v2/nfe/danfe - Gera uma DANFe de Preview (aceita xml no body ou referência)
    // $payload may be ['xml'=>..., 'ref'=>...] or other provider-specific options
    public function danfePreview(array $payload)
    {
        $path = '/v2/nfe/danfe';
        return $this->request('POST', $path, $payload, ['Content-Type: application/json']);
    }

    // ECONF endpoints: register, get, delete
    // POST /v2/nfe/REFERENCIA/econf
    public function econfRegister(string $ref, array $payload)
    {
        $path = '/v2/nfe/' . rawurlencode($ref) . '/econf';
        return $this->request('POST', $path, $payload, ['Content-Type: application/json']);
    }

    // GET /v2/nfe/REFERENCIA/econf/NUMERO_PROTOCOLO
    public function econfGet(string $ref, string $numeroProtocolo)
    {
        $path = '/v2/nfe/' . rawurlencode($ref) . '/econf/' . rawurlencode($numeroProtocolo);
        return $this->request('GET', $path);
    }

    // DELETE /v2/nfe/REFERENCIA/econf/NUMERO_PROTOCOLO
    public function econfDelete(string $ref, string $numeroProtocolo)
    {
        $path = '/v2/nfe/' . rawurlencode($ref) . '/econf/' . rawurlencode($numeroProtocolo);
        return $this->request('DELETE', $path);
    }
}
