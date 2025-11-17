<?php
require_once __DIR__ . '/../../init.php';
require_once __DIR__ . '/../lib/EspoCrmClient.php';

$entity = $argv[1] ?? 'Contact';
try {
    $client = new EspoCrmClient();
    $health = $client->health();
    echo "HEALTH:\n"; print_r($health);
    $list = $client->list($entity, 5, 0);
    echo "\nLIST RAW RESPONSE (first 5):\n"; print_r($list);
} catch (Throwable $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}

/*
Run:
  php app/scripts/espocrm_debug.php Contact
Check keys: status, error, raw.
Possible causes of 500:
 - EspoCRM não está rodando em ESPOCRM_BASE_URL
 - Porta incorreta (verifique 8888 acessível)
 - API Key inválida ou tipo de auth errado
 - Entidade não existe (ex: 'Contact' vs 'Contacts')
 - Falha SSL (se usar https self-signed)
*/
