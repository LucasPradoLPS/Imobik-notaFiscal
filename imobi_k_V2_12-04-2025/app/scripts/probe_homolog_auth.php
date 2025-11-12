<?php
// Try different authentication headers for /v2/nfe to discover required auth scheme
$configFile = __DIR__ . '/../config/focus_nfe.php';
$conf = file_exists($configFile) ? include $configFile : [];
$env = $conf['environment'] ?? getenv('FOCUS_ENV') ?: 'homolog';
$base = $conf['environments'][$env]['base_url'] ?? 'https://homologacao.focusnfe.com.br';
$token = getenv('FOCUS_NFE_TOKEN_HOMOLOG') ?: ($conf['environments']['homolog']['token'] ?? '') ?: '';
$path = '/v2/nfe';
$url = rtrim($base, '/') . $path;
$sample = file_get_contents(__DIR__ . '/samples/sample_nfe.xml');
if ($sample === false) { echo "sample missing\n"; exit(1); }
$payload = json_encode(['xml' => $sample]);

$variants = [
    ['label'=>'Bearer Authorization','headers'=>["Authorization: Bearer {$token}", 'Content-Type: application/json']],
    ['label'=>'X-API-KEY header','headers'=>["x-api-key: {$token}", 'Content-Type: application/json']],
    ['label'=>'X-API-KEY uppercase','headers'=>["X-API-KEY: {$token}", 'Content-Type: application/json']],
    ['label'=>'Authorization Token','headers'=>["Authorization: Token {$token}", 'Content-Type: application/json']],
    ['label'=>'Basic auth (token as user, blank pass)','headers'=>['Content-Type: application/json'],'basic'=>$token.':'],
];

echo "Probing auth variants to {$url}\n";
foreach ($variants as $v) {
    echo "---\nVariant: {$v['label']}\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    if (isset($v['basic'])) {
        curl_setopt($ch, CURLOPT_USERPWD, $v['basic']);
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $v['headers']);
    $body = curl_exec($ch);
    $errno = curl_errno($ch);
    $err = curl_error($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($errno) {
        echo "cURL err {$errno}: {$err}\n";
    } else {
        echo "HTTP {$code}\n";
        $trim = trim($body ?? '');
        if (strlen($trim)>0) echo "Body:\n" . substr($trim,0,2000) . "\n";
    }
}

echo "Done\n";
