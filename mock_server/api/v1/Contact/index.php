<?php
// Mock server file-backed Contact handler
header('Content-Type: application/json; charset=utf-8');
$storage = __DIR__ . '/../../tmp/espocrm_contacts.json';
@mkdir(dirname($storage), 0755, true);
function load_data($f){
    if (!file_exists($f)) {
        $seed = [
            ['id'=>'m1','firstName'=>'Teste','lastName'=>'Local'],
            ['id'=>'m2','firstName'=>'Mock','lastName'=>'Contact']
        ];
        file_put_contents($f, json_encode($seed, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }
    $raw = @file_get_contents($f);
    $a = json_decode($raw, true);
    return is_array($a)?$a:[];
}
function save_data($f, $arr){ file_put_contents($f, json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)); }

$data = load_data($storage);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$id = $_GET['id'] ?? null;

// sanitize incoming input to avoid leaking wrapper params (class/method/etc.)
function sanitize_input(array $input): array {
    $blacklist = ['class','method','entity','controller','token_mobile','token','_'];
    foreach ($blacklist as $k) {
        if (array_key_exists($k, $input)) {
            unset($input[$k]);
        }
    }
    foreach ($input as $k => $v) {
        if (is_string($k) && trim($k) === '') unset($input[$k]);
    }
    return $input;
}

if ($method === 'GET') {
    if ($id) {
        foreach ($data as $item) if ($item['id'] == $id) { echo json_encode(['data'=>$item]); exit; }
        http_response_code(404); echo json_encode(['error'=>'not found']); exit;
    }
    echo json_encode(['body'=>$data]); exit;
}
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?: [];
    if ((empty($input) || !is_array($input)) && !empty($_POST)) { $input = $_POST; }
    if (is_array($input)) { $input = sanitize_input($input); }
    $next = 1; foreach ($data as $it) { if (preg_match('/m(\d+)/',$it['id'],$m)) $next = max($next, intval($m[1])+1); }
    $new = array_merge(['id'=>'m'.$next], $input);
    $data[] = $new; save_data($storage,$data);
    echo json_encode(['data'=>$new]); exit;
}
if ($method === 'PUT') {
    if (!$id) { http_response_code(400); echo json_encode(['error'=>'missing id']); exit; }
    $input = json_decode(file_get_contents('php://input'), true) ?: [];
    if ((empty($input) || !is_array($input)) && !empty($_POST)) { $input = $_POST; }
    if (is_array($input)) { $input = sanitize_input($input); }
    foreach ($data as &$item) if ($item['id'] == $id) { $item = array_merge($item, $input); save_data($storage,$data); echo json_encode(['data'=>$item]); exit; }
    http_response_code(404); echo json_encode(['error'=>'not found']); exit;
}
if ($method === 'DELETE') {
    if (!$id) { http_response_code(400); echo json_encode(['error'=>'missing id']); exit; }
    $new = array_filter($data, function($it) use($id){ return $it['id'] !== $id; });
    save_data($storage, array_values($new));
    echo json_encode(['success'=>true]); exit;
}
