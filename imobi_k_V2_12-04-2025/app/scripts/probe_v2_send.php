<?php
// Send JSON {xml, ref} to /v2/nfe using Basic auth (token as user) to test required params
$configFile = __DIR__ . '/../config/focus_nfe.php';
$conf = file_exists($configFile) ? include $configFile : [];
$env = $conf['environment'] ?? getenv('FOCUS_ENV') ?: 'homolog';
$base = $conf['environments'][$env]['base_url'] ?? 'https://homologacao.focusnfe.com.br';
$token = getenv('FOCUS_NFE_TOKEN_HOMOLOG') ?: ($conf['environments']['homolog']['token'] ?? '') ?: '';
$url = rtrim($base, '/') . '/v2/nfe';
$sample = file_get_contents(__DIR__ . '/samples/sample_nfe.xml');
if ($sample === false) { echo "sample missing\n"; exit(1); }
$payload = json_encode(['xml' => $sample, 'ref' => 'test-ref-'.time()]);

echo "POSTing to {$url} with Basic auth (token as user) and ref...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_USERPWD, $token . ':');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$body = curl_exec($ch);
$errno = curl_errno($ch);
$err = curl_error($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($errno) {
    echo "cURL err {$errno}: {$err}\n";
} else {
    echo "HTTP {$code}\n";
    echo "Body:\n" . ($body ?? '') . "\n";
}
