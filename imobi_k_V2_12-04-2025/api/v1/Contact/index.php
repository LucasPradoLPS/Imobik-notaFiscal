<?php
// Simple file-backed mock for /api/v1/Contact
header('Content-Type: application/json; charset=utf-8');
$storage = __DIR__ . '/../../tmp/espocrm_contacts.json';
// ensure tmp dir exists
@mkdir(dirname($storage), 0755, true);
// diagnostic log for incoming payloads
$dbg = __DIR__ . '/../../tmp/espocrm_contact_debug.log';
@file_put_contents($dbg, date('c') . " | start | method=" . ($_SERVER['REQUEST_METHOD'] ?? 'NA') . " | query=" . ($_SERVER['QUERY_STRING'] ?? '') . "\n", FILE_APPEND);
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
// capture raw input and parsed JSON if present
$rawInput = @file_get_contents('php://input');
$parsedInput = json_decode($rawInput, true);
if (!is_array($parsedInput)) { $parsedInput = null; }
// If php://input was empty (internal dispatch quirk), try payload file exposed by client
if ((empty($rawInput) || strlen(trim($rawInput))===0) && !empty($_SERVER['ESPCRM_INTERNAL_PAYLOAD_FILE'])) {
    $f = $_SERVER['ESPCRM_INTERNAL_PAYLOAD_FILE'];
    if (file_exists($f)) {
        $rawFile = @file_get_contents($f);
        if ($rawFile !== false && strlen(trim($rawFile))>0) {
            $rawInput = $rawFile;
            $tmpParsed = json_decode($rawInput, true);
            if (is_array($tmpParsed)) {
                $parsedInput = $tmpParsed;
                @file_put_contents($dbg, date('c') . " | used-internal-payload-file={$f} | len=" . strlen($rawInput) . "\n", FILE_APPEND);
            }
        }
    }
}
@file_put_contents($dbg, date('c') . " | rawLen=" . strlen($rawInput) . " | parsed=" . ($parsedInput?json_encode($parsedInput, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES):'null') . " | _POST=" . json_encode($_POST, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . "\n", FILE_APPEND);

// If the internal proxy dispatched the request and the outer method was lost
// (arrives as GET but contains a body or an internal payload file), allow
// interpreting it as POST/PUT based on the forwarded proxy method parameter.
if ($method === 'GET' && (strlen(trim($rawInput))>0 || !empty($_POST) || !empty($_SERVER['ESPCRM_INTERNAL_PAYLOAD_FILE'] ?? ''))) {
    $proxyMethod = $_GET['method'] ?? null;
    if ($proxyMethod === 'create') {
        $method = 'POST';
    } elseif ($proxyMethod === 'update') {
        $method = 'PUT';
    }
    @file_put_contents($dbg, date('c') . " | adjusted-method-to={$method} due-to-proxyMethod=" . ($proxyMethod ?? 'NA') . "\n", FILE_APPEND);
}

// sanitize incoming input to avoid leaking wrapper params (class/method/etc.)
function sanitize_input(array $input): array {
    $blacklist = ['class','method','entity','controller','token_mobile','token','_'];
    foreach ($blacklist as $k) {
        if (array_key_exists($k, $input)) {
            unset($input[$k]);
        }
    }
    // also remove numeric-indexed duplicates that may appear
    foreach ($input as $k => $v) {
        if (is_string($k) && trim($k) === '') unset($input[$k]);
    }
    return $input;
}

if ($method === 'GET') {
    if ($id) {
        foreach ($data as $item) if ($item['id'] == $id) { echo json_encode(['status'=>200,'success'=>true,'data'=>$item]); exit; }
        http_response_code(404); echo json_encode(['status'=>404,'success'=>false,'error'=>'not found']); exit;
    }
    echo json_encode(['status'=>200,'success'=>true,'data'=>$data]); exit;
}
if ($method === 'POST') {
    $input = $parsedInput ?: (json_decode(file_get_contents('php://input'), true) ?: []);
    if ((empty($input) || !is_array($input)) && !empty($_POST)) { $input = $_POST; }
    if (is_array($input)) { $input = sanitize_input($input); }
    @file_put_contents($dbg, date('c') . " | post-input=" . json_encode($input, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . "\n", FILE_APPEND);
    // generate id
    $next = 1; foreach ($data as $it) { if (preg_match('/m(\d+)/',$it['id'],$m)) $next = max($next, intval($m[1])+1); }
    $new = array_merge(['id'=>'m'.$next], $input);
    $data[] = $new; save_data($storage,$data);
    echo json_encode(['status'=>201,'success'=>true,'data'=>$new]); exit;
}
if ($method === 'PUT') {
    if (!$id) { http_response_code(400); echo json_encode(['status'=>400,'success'=>false,'error'=>'missing id']); exit; }
    $input = $parsedInput ?: (json_decode(file_get_contents('php://input'), true) ?: []);
    if ((empty($input) || !is_array($input)) && !empty($_POST)) { $input = $_POST; }
    if (is_array($input)) { $input = sanitize_input($input); }
    @file_put_contents($dbg, date('c') . " | put-input=" . json_encode($input, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . "\n", FILE_APPEND);
    foreach ($data as &$item) if ($item['id'] == $id) { $item = array_merge($item, $input); save_data($storage,$data); echo json_encode(['status'=>200,'success'=>true,'data'=>$item]); exit; }
    http_response_code(404); echo json_encode(['status'=>404,'success'=>false,'error'=>'not found']); exit;
}
if ($method === 'DELETE') {
    if (!$id) { http_response_code(400); echo json_encode(['status'=>400,'success'=>false,'error'=>'missing id']); exit; }
    $new = array_filter($data, function($it) use($id){ return $it['id'] !== $id; });
    save_data($storage, array_values($new));
    echo json_encode(['status'=>200,'success'=>true]); exit;
}
