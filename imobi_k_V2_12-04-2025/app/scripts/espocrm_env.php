<?php
// Ensure init.php runs so the .env loader is executed
@require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'init.php';

// Dump current environment variables relevant to EspoCRM integration
$keys = [
    'ESPOCRM_BASE_URL',
    'ESPOCRM_API_KEY',
    'ESPOCRM_AUTH_TYPE',
    'ESPOCRM_CONNECT_TIMEOUT',
    'ESPOCRM_TIMEOUT',
    'ESPOCRM_LOG'
];
$result = [];
foreach ($keys as $k) {
    $v = getenv($k);
    $result[$k] = ($v === false) ? null : $v;
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'loaded' => $result,
    'cwd' => getcwd(),
    'init_included' => defined('APPLICATION_NAME'),
    'session_save_path' => session_save_path(),
], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
