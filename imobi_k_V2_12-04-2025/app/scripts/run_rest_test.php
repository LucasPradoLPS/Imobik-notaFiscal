<?php
require_once __DIR__ . '/../service/rest/EspoCrmRestService.php';

try {
    $res = EspoCrmRestService::getContacts(['page' => 1, 'pageSize' => 2]);
    echo "Result:\n";
    echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, "Exception: " . $e->getMessage() . PHP_EOL);
    fwrite(STDERR, "Trace:\n" . $e->getTraceAsString() . PHP_EOL);
    exit(1);
}
