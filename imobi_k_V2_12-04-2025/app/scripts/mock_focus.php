<?php
// Mock HTTP endpoints for Focus NFe to use in local testing.
// Run with: php -S localhost:8081 mock_focus.php

// Simple router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

header_remove();

if ($uri === '/health') {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok', 'env' => 'mock']);
    exit;
}

if ($uri === '/nfe' && $method === 'POST') {
    // read body (XML expected)
    $body = file_get_contents('php://input');
    // generate fake chave and protocolo
    $chave = '35' . str_pad((string)rand(10000000000000, 99999999999999), 44, '0', STR_PAD_LEFT);
    $prot = (string)rand(100000000000000, 999999999999999);
    header('Content-Type: application/json');
    http_response_code(201);
    echo json_encode([
        'cStat' => 100,
        'xMotivo' => 'Autorizado o uso da NF-e (mock)',
        'chave' => $chave,
        'nProt' => $prot,
    ]);
    exit;
}

// status by chave: /nfe/{chave}/status
if (preg_match('#^/nfe/([^/]+)/status$#', $uri, $m) && $method === 'GET') {
    $chave = $m[1];
    header('Content-Type: application/json');
    echo json_encode([
        'cStat' => 100,
        'xMotivo' => 'Autorizado (mock)',
        'chave' => $chave,
        'status' => 'autorizada'
    ]);
    exit;
}

// pdf endpoint: /nfe/{chave}/pdf
if (preg_match('#^/nfe/([^/]+)/pdf$#', $uri, $m) && $method === 'GET') {
    // return a tiny PDF (placeholder)
    header('Content-Type: application/pdf');
    // Minimal PDF binary (one empty page)
    $pdf = "%PDF-1.4\n%âãÏÓ\n1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 200 200] /Contents 4 0 R >>\nendobj\n4 0 obj\n<< /Length 44 >>\nstream\nBT /F1 24 Tf 50 100 Td (DANFE MOCK) Tj ET\nendstream\nendobj\nxref\n0 5\n0000000000 65535 f \n0000000010 00000 n \n0000000060 00000 n \n0000000110 00000 n \n0000000220 00000 n \ntrailer<< /Root 1 0 R /Size 5 >>\nstartxref\n330\n%%EOF";
    echo $pdf;
    exit;
}

// cancel endpoint: /nfe/{chave}/cancel (POST)
if (preg_match('#^/nfe/([^/]+)/cancel$#', $uri, $m) && $method === 'POST') {
    $chave = $m[1];
    // read body (json expected or form)
    $body = file_get_contents('php://input');
    $data = [];
    $trim = trim($body ?? '');
    if (strlen($trim) > 0) {
        // try json
        $decoded = json_decode($body, true);
        if (is_array($decoded)) {
            $data = $decoded;
        } else {
            // try parse urlencoded
            parse_str($body, $data);
        }
    }
    $just = $data['justificativa'] ?? ($data['justificativa'] ?? 'Cancelamento solicitado (mock)');

    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode([
        'cStat' => 101,
        'xMotivo' => 'Cancelamento homologado (mock)',
        'chave' => $chave,
        'justificativa' => $just,
        'nProtCancel' => (string)rand(100000000000000, 999999999999999),
    ]);
    exit;
}

// Default: 404
http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'not_found', 'path' => $uri]);
