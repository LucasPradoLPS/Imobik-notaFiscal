<?php
/**
 * EspoCrmView
 * Minimal stub to satisfy Adianti instantiation when referenced in menus.
 */
class EspoCrmView extends TPage
{
    private $panel;

    public function __construct()
    {
        parent::__construct();

        if (class_exists('TPanelGroup')) {
            $this->panel = new TPanelGroup('EspoCRM');
            $this->panel->add(new TLabel('EspoCRM integration is available.'));
            parent::add($this->panel);
        } else {
            echo "EspoCRM view placeholder";
        }
    }

    public function onShow($params = null)
    {
        $entity = 'contact';
        if (is_array($params) && isset($params['entity']) && $params['entity'] !== '') {
            $entity = $params['entity'];
        } elseif (isset($_GET['entity']) && $_GET['entity'] !== '') {
            $entity = $_GET['entity'];
        }

        $label = ($entity === 'lead' || $entity === 'leads') ? 'Leads' : 'Contatos';
        if ($this->panel && method_exists($this->panel, 'setTitle')) {
            $this->panel->setTitle('EspoCRM - ' . $label);
        }

        // Validação leve de configuração
        $cfgStatus = $this->checkConfig();
        if (!$cfgStatus['ok'] && $this->panel) {
            $warn = new TElement('div');
            $warn->style = 'background:#fff3cd;border:1px solid #ffeeba;color:#856404;padding:10px;border-radius:6px;margin-bottom:10px;';
            $warn->add($cfgStatus['message']);
            $this->panel->add($warn);
        }

        // Pequeno status do proxy/CRM para ajudar no diagnóstico
        $health = $this->fetchHealth();
        if ($this->panel && is_array($health)) {
            $ok = !empty($health['reachable']) && !empty($health['api_key_present']) && !empty($health['base_url']);
            $box = new TElement('div');
            $box->style = 'padding:8px;border-radius:6px;margin-bottom:10px;'.($ok? 'background:#e6ffed;border:1px solid #b7eb8f;color:#135200;' : 'background:#fff3cd;border:1px solid #ffeeba;color:#856404;');
            $txt = 'CRM ' . ($ok? 'online' : 'fora do ar') . ' • ' . ($health['base_url'] ?? 'sem URL');
            if (isset($health['http_code'])) { $txt .= ' • http '.$health['http_code']; }
            $box->add($txt);
            $this->panel->add($box);
        }

        // Chamada mínima ao proxy para exibir um preview de dados em JSON
        $resource = ($entity === 'lead' || $entity === 'leads') ? 'leads' : 'contacts';
        $raw = $this->fetchProxy($resource);

        $decoded = json_decode($raw, true);
        $tableAdded = false;
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            // Se o proxy retornou um erro estruturado, mostrar aviso amigável
            if (isset($decoded['error'])) {
                $msg = 'Falha ao consultar EspoCRM.';
                if (!empty($decoded['message'])) { $msg .= ' ' . $decoded['message']; }
                if ($this->panel) {
                    $warn = new TElement('div');
                    $warn->style = 'background:#fff3cd;border:1px solid #ffeeba;color:#856404;padding:10px;border-radius:6px;margin-bottom:10px;';
                    $warn->add($msg);
                    $this->panel->add($warn);
                }
            }
            $items = [];
            if (isset($decoded['list']) && is_array($decoded['list'])) {
                $items = $decoded['list'];
            } elseif (isset($decoded['data']) && is_array($decoded['data'])) {
                $items = $decoded['data'];
            } elseif ($this->isSequentialArray($decoded)) {
                $items = $decoded; // já é uma lista
            }

            if (!empty($items) && $this->panel) {
                $this->panel->add($this->buildListTable($items));
                $tableAdded = true;
            }
        }

        // Sempre mostrar o JSON bruto abaixo como referência (caso precise debugar)
        if ($this->panel) {
            $pre = new TElement('pre');
            $pre->style = 'max-height: 360px; overflow:auto; background:#111; color:#eee; padding:10px; border-radius:6px; margin-top:10px;';
            $pre->add($tableAdded ? "\n\n// Prévia JSON" : $raw);
            if ($tableAdded) {
                $pre->add("\n" . $this->prettyJson($raw));
            }
            $this->panel->add($pre);
        }
    }

    private function fetchHealth()
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1:8080';
        if (!$host) { $host = '127.0.0.1:8080'; }
        $url = $scheme . '://' . $host . '/api/v1/espocrm.php?health=1';
        $body = null;
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_TIMEOUT, 4);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            $resp = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($resp) { $decoded = json_decode($resp, true); if (json_last_error()===JSON_ERROR_NONE) { $decoded['http_code'] = $code; return $decoded; } }
            return null;
        } else {
            $ctx = stream_context_create(['http'=>['method'=>'GET','timeout'=>4,'ignore_errors'=>true]]);
            $resp = @file_get_contents($url, false, $ctx);
            if ($resp) { $decoded = json_decode($resp, true); if (json_last_error()===JSON_ERROR_NONE) { return $decoded; } }
            return null;
        }
    }

    private function fetchProxy(string $resource): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $hostHeader = $_SERVER['HTTP_HOST'] ?? '';
        $candidates = [];
        // Prefer ESPOCRM_BASE_URL if set in environment/config
        $envBase = getenv('ESPOCRM_BASE_URL');
        if ($envBase && is_string($envBase)) {
            $parts = parse_url($envBase);
            if (isset($parts['host'])) {
                $hostPort = $parts['host'] . (isset($parts['port']) ? ':' . $parts['port'] : '');
                $candidates[] = $hostPort;
            }
        }
        if ($hostHeader) { $candidates[] = $hostHeader; }
        // legacy fallbacks
        $candidates[] = '127.0.0.1:8080';
        $candidates[] = 'localhost:8080';

        $lastError = null; $lastCode = null; $lastBody = null; $lastUrl = null; $lastDiag = null;

        foreach ($candidates as $host) {
            $base = $scheme . '://' . $host . '/api/v1/espocrm.php';
            $url = $base . '?resource=' . urlencode($resource) . '&maxSize=10';
            $diagUrl = $base . '?diagnostic=1';
            $lastUrl = $url;

            if (function_exists('curl_init')) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($ch, CURLOPT_TIMEOUT, 8);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                $body = curl_exec($ch);
                $err  = curl_error($ch);
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if (!$err && $code < 400 && $body !== false && $body !== '') {
                    return $this->prettyJson($body);
                }
                $lastError = $err ?: ('http '.$code);
                $lastCode = $code; $lastBody = $body;
                $lastDiag = @file_get_contents($diagUrl);
                continue; // tenta próximo host
            }
            // Fallback file_get_contents
            $ctx = stream_context_create(['http' => ['method' => 'GET','timeout' => 6,'ignore_errors' => true]]);
            $body = @file_get_contents($url, false, $ctx);
            if ($body !== false && $body !== '') { return $this->prettyJson($body); }
            $lastError = 'fgc failed'; $lastBody = $body; $lastDiag = @file_get_contents($diagUrl);
        }

        return json_encode([
            'error' => 'proxy request failed',
            'message' => (string) $lastError,
            'status' => $lastCode,
            'proxy_url' => (string) $lastUrl,
            'diagnostic' => $this->safeJson($lastDiag)
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function safeJson($maybeJson)
    {
        if (!is_string($maybeJson) || $maybeJson === '') return $maybeJson;
        $decoded = json_decode($maybeJson, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
        return $maybeJson;
    }

    private function prettyJson($body): string
    {
        $decoded = json_decode($body, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        // já é texto/erro
        return (string) $body;
    }

    private function isSequentialArray(array $arr): bool
    {
        if ($arr === []) return true;
        return array_keys($arr) === range(0, count($arr) - 1);
    }

    private function buildListTable(array $items)
    {
        $limit = 10;
        $rows = array_slice($items, 0, $limit);

        $wrapper = new TElement('div');
        $wrapper->style = 'overflow:auto;';

        $table = new TElement('table');
        $table->style = 'width:100%; border-collapse:collapse;';
        $table->border = 1;

        $thead = new TElement('thead');
        $trh = new TElement('tr');
        foreach (['ID', 'Nome', 'Email'] as $h) {
            $th = new TElement('th');
            $th->style = 'text-align:left;padding:6px;background:#f6f6f6;';
            $th->add($h);
            $trh->add($th);
        }
        $thead->add($trh);
        $table->add($thead);

        $tbody = new TElement('tbody');
        foreach ($rows as $r) {
            if (!is_array($r)) continue;
            $tr = new TElement('tr');
            $id = isset($r['id']) ? (string)$r['id'] : '';
            $name = $this->extractName($r);
            $email = $this->extractEmail($r);

            foreach ([$id, $name, $email] as $cell) {
                $td = new TElement('td');
                $td->style = 'padding:6px;border-top:1px solid #eaeaea;';
                $td->add($cell);
                $tr->add($td);
            }
            $tbody->add($tr);
        }
        $table->add($tbody);

        $wrapper->add($table);
        return $wrapper;
    }

    private function extractName(array $r): string
    {
        if (!empty($r['name'])) return (string)$r['name'];
        $first = trim((string)($r['firstName'] ?? ''));
        $last  = trim((string)($r['lastName'] ?? ''));
        $full = trim($first . ' ' . $last);
        if ($full !== '') return $full;
        if (!empty($r['accountName'])) return (string)$r['accountName'];
        return '';
    }

    private function extractEmail(array $r): string
    {
        if (!empty($r['emailAddress'])) return (string)$r['emailAddress'];
        if (!empty($r['email'])) return (string)$r['email'];
        if (!empty($r['emailAddressData']) && is_array($r['emailAddressData'])) {
            foreach ($r['emailAddressData'] as $e) {
                if (is_array($e) && (!isset($e['invalid']) || !$e['invalid'])) {
                    return (string)($e['emailAddress'] ?? '');
                }
            }
        }
        return '';
    }

    private function checkConfig(): array
    {
        $baseUrl = getenv('ESPOCRM_BASE_URL') ?: '';
        $apiKey  = getenv('ESPOCRM_API_KEY') ?: '';

        $cfgPath = realpath(__DIR__ . '/../config/espocrm.php');
        if ($cfgPath && file_exists($cfgPath)) {
            $cfg = include $cfgPath;
            if (!$baseUrl) $baseUrl = $cfg['base_url'] ?? '';
            if (!$apiKey)  $apiKey  = $cfg['api_key'] ?? '';
        }

        if (!$baseUrl || !$apiKey) {
            return [
                'ok' => false,
                'message' => 'Configuração do EspoCRM ausente/incompleta. Defina ESPOCRM_BASE_URL e ESPOCRM_API_KEY no ambiente ou em app/config/espocrm.php.'
            ];
        }
        return ['ok' => true, 'message' => ''];
    }
}
