<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'body' => [
        ['id' => 'a1', 'name' => 'Account One'],
        ['id' => 'a2', 'name' => 'Account Two']
    ]
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
