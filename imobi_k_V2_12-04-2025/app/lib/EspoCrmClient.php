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

    public function health(): array
    {
        $r = $this->request('GET', 'api/v1/metadata');
        return [
            'ok' => ($r['status'] ?? 0) >= 200 && ($r['status'] ?? 0) < 500,
            'status' => $r['status'] ?? 0,
            'error' => $r['error'] ?? null
        ];
    }

    public function list(string $entity, int $maxSize = 20, int $offset = 0): array
    {
        return $this->request('GET', 'api/v1/' . rawurlencode($entity) . '?maxSize=' . $maxSize . '&offset=' . $offset);
    }
    public function getRecord(string $entity, string $id): array { return $this->request('GET', 'api/v1/' . rawurlencode($entity) . '/' . rawurlencode($id)); }
    public function create(string $entity, array $data): array { return $this->request('POST', 'api/v1/' . rawurlencode($entity), $data); }
    public function update(string $entity, string $id, array $data): array { return $this->request('PUT', 'api/v1/' . rawurlencode($entity) . '/' . rawurlencode($id), $data); }
    public function delete(string $entity, string $id): array { return $this->request('DELETE', 'api/v1/' . rawurlencode($entity) . '/' . rawurlencode($id)); }
}
