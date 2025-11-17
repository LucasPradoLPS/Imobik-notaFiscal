<?php
// Converte um XML de NF-e para JSON e reenvia para a API Focus (ambiente production)
// Uso: php resend_nfe_from_xml.php /caminho/para/nfe.xml [endpoint] [override_cnpj]

$argv0 = $argv[0] ?? 'resend_nfe_from_xml.php';
if (!isset($argv[1]) || in_array($argv[1], ['-h','--help'])) {
    $usage = <<<USAGE
Usage: php {$argv0} /caminho/para/nfe.xml [endpoint] [override_cnpj]

  /caminho/para/nfe.xml   Arquivo XML da NF-e
  endpoint                Caminho do endpoint (ex: /nfe or /v1/nfe). Padrão: /nfe
  override_cnpj           CNPJ do emitente (14 dígitos ou com pontuação)

Exemplo:
  php {$argv0} files/nfe/nfe_20251112151158.xml /nfe 02.143.703/0001-02
USAGE;
    echo $usage . "\n";
    exit(1);
}

$xmlFile = $argv[1];
$endpoint = $argv[2] ?? '/v2/nfe';
$overrideCnpj = $argv[3] ?? null;
// referência para o POST (query param 'ref'), por padrão usa o nome do arquivo sem extensão
$ref = $argv[4] ?? pathinfo($xmlFile, PATHINFO_FILENAME);

if (!is_file($xmlFile)) {
    fwrite(STDERR, "Erro: arquivo XML não encontrado: {$xmlFile}\n");
    exit(2);
}

// carrega config e força production
$config = require __DIR__ . '/../config/focus_nfe.php';
$env = 'production';
$envConf = $config['environments'][$env] ?? [];
$token = $envConf['token'] ?? '';
$baseUrl = rtrim($envConf['base_url'] ?? '', '/');

if ($token === '') {
    fwrite(STDERR, "Erro: token de produção não configurado.\n");
    exit(3);
}

libxml_use_internal_errors(true);
$xml = simplexml_load_file($xmlFile, 'SimpleXMLElement', LIBXML_NOCDATA);
if ($xml === false) {
    fwrite(STDERR, "Erro: falha ao carregar XML. Erros:\n");
    foreach (libxml_get_errors() as $err) {
        fwrite(STDERR, $err->message . "\n");
    }
    exit(4);
}

// converte SimpleXMLElement para array
$jsonFromXml = json_encode($xml);
$data = json_decode($jsonFromXml, true);

// Aplicar override do CNPJ se passado (normaliza para 14 dígitos)
if ($overrideCnpj) {
    $clean = preg_replace('/\D+/', '', $overrideCnpj);
    if (strlen($clean) === 14) {
        // tentativa de localizar nó emitente no array: pode ser 'infNFe'->'emit' ou 'emit'
        if (isset($data['infNFe']['emit'])) {
            $data['infNFe']['emit']['CNPJ'] = $clean;
        } elseif (isset($data['emit'])) {
            $data['emit']['CNPJ'] = $clean;
        } else {
            // tenta localizar profundamente
            $data['emit']['CNPJ'] = $clean;
        }
        echo "Aplicado override emit.CNPJ = {$clean}\n";
    } else {
        fwrite(STDERR, "Aviso: CNPJ override inválido: {$overrideCnpj}\n");
    }
}

$payload = json_encode($data, JSON_UNESCAPED_UNICODE);

$url = $baseUrl . $endpoint;
// adiciona query param ref para criação
if ($ref) {
    $url .= (strpos($url, '?') === false ? '?' : '&') . 'ref=' . urlencode($ref);
}

echo "Enviando para: {$url}\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
// Autenticação: Focus NFe usa HTTP Basic com o token como usuário e senha vazia
curl_setopt($ch, CURLOPT_USERPWD, $token . ':');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
curl_close($ch);

echo "HTTP Status: {$httpCode}\n";
if ($err) {
    fwrite(STDERR, "cURL error: {$err}\n");
}

$decoded = json_decode($response, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
} else {
    echo $response . "\n";
}

exit(0);
