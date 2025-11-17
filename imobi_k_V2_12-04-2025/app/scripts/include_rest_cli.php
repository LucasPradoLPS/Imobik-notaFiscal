<?php
// Emulate an HTTP request to rest.php from CLI so we can capture logs produced by the same code path
$_REQUEST = [
    // EspoCrmRestService removed
    'method' => 'getContacts',
    'page' => 1,
    'pageSize' => 3
];

// Ensure we run from project root equivalent
chdir(__DIR__ . '/..');

include __DIR__ . '/../../rest.php';
