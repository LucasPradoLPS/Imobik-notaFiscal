<?php
/** Teste rápido da API EspoCRM. */
require_once __DIR__ . '/../lib/EspoCrmClient.php';
$entity = $argv[1] ?? 'Contact';
try {
    $client = new EspoCrmClient();
    $health = $client->health();
    echo "Health: status={$health['status']} ok=" . ($health['ok'] ? '1' : '0') . PHP_EOL;
    $list = $client->list($entity, 5, 0);
    echo "Lista {$entity}: status={$list['status']}" . PHP_EOL;
    $records = [];
    if (isset($list['list']) && is_array($list['list'])) { $records = $list['list']; }
    elseif (isset($list['data']) && is_array($list['data'])) { $records = $list['data']; }
    foreach ($records as $r) {
        $name = $r['name'] ?? trim(($r['firstName'] ?? '') . ' ' . ($r['lastName'] ?? ''));
        echo " - " . ($r['id'] ?? 'sem-id') . " | " . $name . PHP_EOL;
    }
    if (!$records) {
        echo "Nenhum registro estruturado. Retorno bruto:\n";
        echo json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }
} catch (Throwable $e) {
    fwrite(STDERR, 'Erro: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}
