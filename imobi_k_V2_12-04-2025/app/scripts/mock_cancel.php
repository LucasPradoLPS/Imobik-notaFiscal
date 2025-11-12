<?php
// Cancel a mock NF-e using FocusNFeClient. Usage:
// php mock_cancel.php [chave] [justificativa]
require_once __DIR__ . '/../service/FocusNFeClient.php';

$config = include __DIR__ . '/../config/focus_nfe.php';

// Ensure the config points to the local mock for this script (avoid env dependence)
$env = $config['environment'] ?? ($config['environment'] = 'sandbox');
if (!isset($config['environments'][$env])) {
    // fallback: ensure environments structure exists
    $config = [
        'environment' => 'sandbox',
        'timeout' => 30,
        'environments' => [
            'sandbox' => [ 'base_url' => 'http://localhost:8081', 'token' => 'tN7X5943azf7cgGbqmN6BL3BDZ52pVAm' ],
        ],
    ];
} else {
    // override the sandbox base_url to local mock to be safe
    $config['environments'][$env]['base_url'] = 'http://localhost:8081';
}

$chave = $argv[1] ?? '3500000000000000000000000000000079206852931037';
$just = $argv[2] ?? 'Cancelamento solicitado pelo usuário (mock)';

try {
    $client = new FocusNFeClient($config);
    $res = $client->cancel($chave, $just);
    echo "Cancel HTTP status: " . $res['status'] . "\n";
    if (!empty($res['json'])) print_r($res['json']); else echo $res['body'] . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
