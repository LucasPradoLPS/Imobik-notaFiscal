<?php
/**
 * CrmClient
 * Minimal REST client for EspoCRM-like API.
 */
class CrmClient
{
    private string $baseUrl;
    private string $apiKey;
    private int $timeout = 6;

    public function __construct(array $config)
    {
        $this->baseUrl = rtrim($config['base_url'] ?? '', '/');
        $this->apiKey  = $config['api_key'] ?? '';
    }

    public function isConfigured(): bool
    {
        return $this->baseUrl !== '' && $this->apiKey !== '' && $this->apiKey !== 'COLOQUE_API_KEY_AQUI';
    }

    public function health(): array
    {
        if (!$this->isConfigured()) {
            return ['ok' => false, 'message' => 'Config incompleta'];
        }
        $meta = $this->get('/api/v1/metadata', 3);
        return [
            'ok' => isset($meta['status']) ? ($meta['status'] < 500) : !empty($meta),
            'status' => $meta['status'] ?? null,
            'message' => $meta['error'] ?? '',
            'base_url' => $this->baseUrl
        ];
    }

    /**
     * Fetch list of contacts or leads (simplified)
     */
    public function list(string $entity, int $limit = 10): array
    {
        if (!$this->isConfigured()) {
            return ['error' => 'CRM não configurado'];
        }
        $endpoint = ($entity === 'leads') ? '/api/v1/Lead' : '/api/v1/Contact';
        // EspoCRM list filtering simplified: ?maxSize=limit
        return $this->get($endpoint . '?maxSize=' . $limit);
    }

    private function get(string $path, int $timeout = null): array
    {
        $timeout = $timeout ?? $this->timeout;
        $url = $this->baseUrl . $path;
        $resp = $this->rawRequest('GET', $url, [], $timeout);
        $decoded = json_decode($resp['body'] ?? '', true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $decoded['status'] = $resp['status'];
            return $decoded;
        }
        return [
            'error' => 'invalid json or empty',
            'status' => $resp['status'],
            'body' => $resp['body']
        ];
    }

    private function rawRequest(string $method, string $url, array $headers = [], int $timeout = 6): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        $h = [];
        $h[] = 'Content-Type: application/json';
        if ($this->apiKey) {
            // EspoCRM uses header X-Api-Key
            $h[] = 'X-Api-Key: ' . $this->apiKey;
        }
        foreach ($headers as $k => $v) { $h[] = "$k: $v"; }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
        $body = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            return ['status' => 0, 'error' => $err, 'body' => $body];
        }
        return ['status' => $status, 'body' => $body];
    }
}