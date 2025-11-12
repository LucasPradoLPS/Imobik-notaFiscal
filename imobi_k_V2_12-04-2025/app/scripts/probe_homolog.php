<?php
/**
 * probe_homolog.php
 * Try a small set of candidate endpoints on homologacao.focusnfe.com.br to find the correct POST path.
 * Usage: set FOCUS_NFE_TOKEN_HOMOLOG (or script will use embedded fallback) and run:
 * php probe_homolog.php
 */

$configFile = __DIR__ . '/../config/focus_nfe.php';
$conf = file_exists($configFile) ? include $configFile : [];
$env = $conf['environment'] ?? getenv('FOCUS_ENV') ?: 'homolog';
$base = $conf['environments'][$env]['base_url'] ?? ($conf['environments']['homolog']['base_url'] ?? 'https://homologacao.focusnfe.com.br');

$token = getenv('FOCUS_NFE_TOKEN_HOMOLOG') ?: ($conf['environments']['homolog']['token'] ?? '') ?: '';
if (empty($token)) {
    echo "Warning: FOCUS_NFE_TOKEN_HOMOLOG is empty -- requests may be rejected.\n";
}

$sample = file_get_contents(__DIR__ . '/samples/sample_nfe.xml');
if ($sample === false) {
    echo "sample_nfe.xml not found in app/scripts/samples.\n";
    exit(1);
}

$candidates = [
    '/nfe',
    '/nfe/enviar',
    '/v1/nfe',
    '/v2/nfe',
    '/v2/nfe/enviar',
    '/xml',
];

echo "Probing homolog base: {$base}\n";
foreach ($candidates as $path) {
    $url = rtrim($base, '/') . $path;
    echo "---\nPOST {$url}\n";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $sample);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $headers = [
        'Content-Type: application/xml',
    ];
    if (!empty($token)) $headers[] = 'Authorization: Bearer ' . $token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // capture response
    $body = curl_exec($ch);
    $errno = curl_errno($ch);
    $err = curl_error($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($errno) {
        echo "cURL error ({$errno}): {$err}\n";
    } else {
        echo "HTTP {$code}\n";
        $trim = trim($body ?? '');
        if (strlen($trim) > 0) {
            // print up to 1000 chars
            $out = substr($trim, 0, 1000);
            echo "Body: \n" . $out . "\n";
        } else {
            echo "Empty body\n";
        }
    }
}

echo "Done.\n";
