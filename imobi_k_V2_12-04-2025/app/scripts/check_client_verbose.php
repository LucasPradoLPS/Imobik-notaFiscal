<?php
require_once __DIR__ . '/../lib/EspoCrmClient.php';

// load config
$cfg = include __DIR__ . '/../config/espocrm.php';
echo "Config base_url: " . var_export($cfg['base_url'] ?? null, true) . PHP_EOL;
echo "Config api_key : " . var_export($cfg['api_key'] ?? null, true) . PHP_EOL;
echo "Config auth_type: " . var_export($cfg['auth_type'] ?? null, true) . PHP_EOL;

try {
    $client = new EspoCrmClient($cfg['base_url'] ?? null, $cfg['api_key'] ?? null, $cfg['auth_type'] ?? 'apikey');
    $res = $client->get('/api/v1/Contact', ['limit' => 1]);
    echo "Client call result:\n";
    echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, "Exception: " . $e->getMessage() . PHP_EOL);
    fwrite(STDERR, $e->getTraceAsString() . PHP_EOL);
    exit(1);
}
