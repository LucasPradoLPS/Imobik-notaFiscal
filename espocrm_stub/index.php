<?php
// Simple EspoCRM stub for local testing
header('Content-Type: application/json; charset=utf-8');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

function json_ok($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/' || $uri === '/index.php') {
    json_ok(['ok' => true, 'service' => 'espocrm-stub']);
}

// normalize paths used by proxy: /api/v1/Contact and /api/v1/Lead
if (preg_match('#^/api/v1/(Contact|Lead)(?:/([^/]+))?$#i', $uri, $m)) {
    $entity = strtolower($m[1]);
    $id = $m[2] ?? null;

    if ($method === 'GET') {
        // return a simple list or single item
        if ($id) {
            json_ok(['id' => $id, 'firstName' => 'Stub', 'lastName' => 'User', 'email' => 'stub@example.com']);
        }
        json_ok([
            ['id' => 'm1', 'firstName' => 'Alice', 'lastName' => 'Stub', 'email' => 'alice@example.com'],
            ['id' => 'm2', 'firstName' => 'Bob', 'lastName' => 'Stub', 'email' => 'bob@example.com']
        ]);
    }

    if ($method === 'POST') {
        $body = json_decode(file_get_contents('php://input'), true) ?: [];
        $body['id'] = 'm' . rand(1000,9999);
        http_response_code(201);
        json_ok($body);
    }

    if (in_array($method, ['PUT','PATCH'])) {
        if (!$id) { http_response_code(400); json_ok(['error' => 'id required']); }
        $body = json_decode(file_get_contents('php://input'), true) ?: [];
        $body['id'] = $id;
        json_ok($body);
    }

    if ($method === 'DELETE') {
        if (!$id) { http_response_code(400); json_ok(['error' => 'id required']); }
        json_ok(['deleted' => $id]);
    }
}

// fallback
http_response_code(404);
json_ok(['error' => 'not found', 'path' => $uri]);
