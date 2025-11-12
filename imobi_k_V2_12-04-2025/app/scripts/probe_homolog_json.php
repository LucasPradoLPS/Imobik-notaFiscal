<?php
// Probe candidate endpoints sending JSON wrapper {"xml": "..."}
$configFile = __DIR__ . '/../config/focus_nfe.php';
$conf = file_exists($configFile) ? include $configFile : [];
$env = $conf['environment'] ?? getenv('FOCUS_ENV') ?: 'homolog';
$base = $conf['environments'][$env]['base_url'] ?? ($conf['environments']['homolog']['base_url'] ?? 'https://homologacao.focusnfe.com.br');
$token = getenv('FOCUS_NFE_TOKEN_HOMOLOG') ?: ($conf['environments']['homolog']['token'] ?? '') ?: '';
$sample = file_get_contents(__DIR__ . '/samples/sample_nfe.xml');
if ($sample === false) { echo "sample xml missing\n"; exit(1); }
$payload = json_encode(['xml' => $sample]);
$candidates = ['/v2/nfe','/v2/nfe/enviar','/nfe/enviar','/nfe','/v1/nfe','/nota','/v2/nota'];
echo "Probing JSON wrapper against base: {$base}\n";
foreach ($candidates as $path) {
    $url = rtrim($base, '/') . $path;
    echo "---\nPOST JSON {$url}\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $headers = ['Content-Type: application/json'];
    if (!empty($token)) $headers[] = 'Authorization: Bearer ' . $token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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
        if (strlen($trim) > 0) echo "Body:\n" . substr($trim,0,2000) . "\n";
    }
}
echo "Done\n";
