<?php
require_once '../../init.php';

header('Content-Type: application/json; charset=utf-8');

$cfgPath = __DIR__ . '/../../app/config/crm.php';
$cfg = file_exists($cfgPath) ? include $cfgPath : ['base_url' => '', 'api_key' => ''];
$client = new CrmClient($cfg);
$health = $client->health();

echo json_encode([
    'configured' => $client->isConfigured(),
    'health' => $health,
    'timestamp' => date('c')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);