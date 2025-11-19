<?php
/**
 * Compatibility shim for EspoCRM service calls used by the app.
 * Provides minimal static methods so the app won't throw missing method/class errors.
 */
class EspoCrmRestService
{
    private static function buildClient()
    {
        $cfgFile = __DIR__ . '/../../config/espocrm.php';
        $baseUrl = getenv('ESPOCRM_BASE_URL') ?: null;
        $apiKey  = getenv('ESPOCRM_API_KEY') ?: null;
        $authType = getenv('ESPOCRM_AUTH_TYPE') ?: null;

        if (file_exists($cfgFile)) {
            $cfg = include $cfgFile;
            $baseUrl = $cfg['base_url'] ?? $baseUrl;
            $apiKey  = $cfg['api_key']  ?? $apiKey;
            $authType = $cfg['auth_type'] ?? $authType;
        }

        // include client from app/lib
        $clientPath = __DIR__ . '/../../lib/EspoCrmClient.php';
        if (!file_exists($clientPath)) {
            throw new Exception('EspoCrmClient missing on server');
        }
        require_once $clientPath;

        return new EspoCrmClient($baseUrl, $apiKey, $authType ?: 'apikey');
    }

    public static function getContacts($params = [])
    {
        try {
            $client = self::buildClient();
            $res = $client->get('/api/v1/Contact', $params ?: []);
            return $res['body'] ?? [];
        } catch (Exception $e) {
            throw new Exception(strval($e->getMessage()));
        }
    }

    public static function createContact($data = [])
    {
        try {
            $client = self::buildClient();
            $res = $client->post('/api/v1/Contact', $data ?: []);
            return $res['body'] ?? [];
        } catch (Exception $e) {
            throw new Exception(strval($e->getMessage()));
        }
    }

    public static function updateContact($id, $data = [])
    {
        try {
            $client = self::buildClient();
            $res = $client->put('/api/v1/Contact/' . rawurlencode($id), $data ?: []);
            return $res['body'] ?? [];
        } catch (Exception $e) {
            throw new Exception(strval($e->getMessage()));
        }
    }

    public static function deleteContact($id)
    {
        try {
            $client = self::buildClient();
            $res = $client->delete('/api/v1/Contact/' . rawurlencode($id));
            return $res['body'] ?? ['deleted' => $id];
        } catch (Exception $e) {
            throw new Exception(strval($e->getMessage()));
        }
    }

    // Leads
    public static function getLeads($params = [])
    {
        try {
            $client = self::buildClient();
            $res = $client->get('/api/v1/Lead', $params ?: []);
            return $res['body'] ?? [];
        } catch (Exception $e) {
            throw new Exception(strval($e->getMessage()));
        }
    }

    public static function createLead($data = [])
    {
        try {
            $client = self::buildClient();
            $res = $client->post('/api/v1/Lead', $data ?: []);
            return $res['body'] ?? [];
        } catch (Exception $e) {
            throw new Exception(strval($e->getMessage()));
        }
    }

    public static function updateLead($id, $data = [])
    {
        try {
            $client = self::buildClient();
            $res = $client->put('/api/v1/Lead/' . rawurlencode($id), $data ?: []);
            return $res['body'] ?? [];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function deleteLead($id)
    {
        try {
            $client = self::buildClient();
            $res = $client->delete('/api/v1/Lead/' . rawurlencode($id));
            return $res['body'] ?? ['deleted' => $id];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
