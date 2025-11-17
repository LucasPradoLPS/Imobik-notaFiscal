<?php

$url = "http://127.0.0.1:8888/api/v1/Contact";

$headers = [
    "Content-Type: application/json",
    "X-Api-Key: 11f258a3d44e1acb8831b1bb44b32ae8",
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_ENCODING       => '', // aceita gzip/deflate/br
]);

$response = curl_exec($curl);

if ($response === false) {
    $error = curl_error($curl);
    $errno = curl_errno($curl);
    curl_close($curl);
    die("Erro ao chamar EspoCRM: [$errno] $error\n");
}

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
curl_close($curl);

// Remove BOM se houver
if (strncmp($response, "\xEF\xBB\xBF", 3) === 0) {
    $response = substr($response, 3);
}

echo "HTTP $httpCode\n";
echo "Content-Type: $contentType\n";

// Tenta pretty JSON
$decoded = json_decode($response, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), "\n";
} else {
    echo $response, "\n";
}
