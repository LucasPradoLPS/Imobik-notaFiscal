<?php
// Test script to send sample_nfe.xml to the mock Focus server using FocusNFeClient
require_once __DIR__ . '/../service/FocusNFeClient.php';

$config = include __DIR__ . '/../config/focus_nfe.php';

try {
    $client = new FocusNFeClient($config);
    $sampleXml = file_get_contents(__DIR__ . '/samples/sample_nfe.xml');
    if ($sampleXml === false) {
        echo "sample_nfe.xml not found\n";
        exit(1);
    }

    echo "Sending sample XML to: " . ($config['environments'][$config['environment']]['base_url'] ?? $config['base_url'] ?? '(unknown)') . "\n";
    $res = $client->sendInvoiceXml($sampleXml);
    echo "HTTP status: " . $res['status'] . "\n";
    if (!empty($res['json'])) {
        print_r($res['json']);
        $chave = $res['json']['chave'] ?? null;
    } else {
        echo $res['body'] . "\n";
        $chave = null;
    }

    if ($chave) {
        echo "Querying status for chave: $chave\n";
        $st = $client->getStatusByKey($chave);
        echo "Status HTTP: " . $st['status'] . "\n";
        if (!empty($st['json'])) print_r($st['json']); else echo $st['body'];
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
