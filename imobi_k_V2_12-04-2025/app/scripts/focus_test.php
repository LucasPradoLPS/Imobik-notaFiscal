<?php
// Script de exemplo para usar FocusNFeClient
require_once __DIR__ . '/../service/FocusNFeClient.php';

$config = include __DIR__ . '/../config/focus_nfe.php';

try {
    $client = new FocusNFeClient($config);

    // 1) Testar autenticação / ping básico (se a API tiver endpoint de health)
    try {
        $res = $client->request('GET', '/health'); // se existir
        echo "Health status: " . $res['status'] . "\n";
        if ($res['json']) print_r($res['json']);
    } catch (Exception $e) {
        echo "Health check falhou (pode ser normal se endpoint não existir): " . $e->getMessage() . "\n";
    }

    // 2) Enviar XML de teste
    $sampleXml = file_get_contents(__DIR__ . '/samples/sample_nfe.xml'); // coloque um XML válido aqui
    if ($sampleXml !== false) {
        echo "Enviando XML...\n";
        $send = $client->sendInvoiceXml($sampleXml);
        echo "Status: " . $send['status'] . "\n";
        if ($send['json']) print_r($send['json']); else echo $send['body'] . "\n";
    } else {
        echo "Arquivo de exemplo não encontrado: app/scripts/samples/sample_nfe.xml\n";
    }

    // 3) Consultar por chave (substitua pela chave real)
    $chave = 'COLOQUE_A_CHAVE_AQUI';
    $status = $client->getStatusByKey($chave);
    echo "Consulta status (HTTP " . $status['status'] . "): \n";
    if ($status['json']) print_r($status['json']); else echo $status['body'];

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
