<?php
header('Content-Type: application/json');
$response = [
    'body' => [
        ['id' => 'l1', 'firstName' => 'Lead', 'lastName' => 'One', 'email' => 'lead1@example.com'],
        ['id' => 'l2', 'firstName' => 'Lead', 'lastName' => 'Two', 'email' => 'lead2@example.com']
    ]
];
echo json_encode($response);
