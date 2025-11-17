<?php
// Script simples para enviar um JSON de NF-e para a Focus NFe usando o token do config
// Uso: php send_focus_nfe.php /caminho/para/nota.json [endpoint]

$config = require __DIR__ . '/../config/focus_nfe.php';

$env = $config['environment'] ?? 'homolog';
$envConf = $config['environments'][$env] ?? [];
$token = $envConf['token'] ?? '';
$baseUrl = rtrim($envConf['base_url'] ?? '', '/');

if ($token === '') {
    fwrite(STDERR, "Erro: token não encontrado na configuração (FOCUS_NFE_TOKEN_*).\n");
    exit(1);
}

$argv0 = $argv[0] ?? 'send_focus_nfe.php';
// parâmetros: arquivo-json [endpoint] [override_cnpj]
if (!isset($argv[1]) || in_array($argv[1], ['-h','--help'])) {
    $usage = <<<USAGE
Usage: php {$argv0} /caminho/para/nota.json [endpoint]

  /caminho/para/nota.json    Arquivo JSON da nota (se -, lê do STDIN)
  endpoint                   Caminho do endpoint (ex: /nfe ou /v1/nfe). Padrão: /nfe

Exemplo:
  php {$argv0} nota.json /v1/nfe
  type nota.json | php {$argv0} - /v1/nfe
USAGE;
    echo $usage . "\n";
    exit(1);
}

$file = $argv[1];
$endpoint = $argv[2] ?? getenv('FOCUS_NFE_ENDPOINT') ?: '/nfe';
$overrideCnpj = $argv[3] ?? null;

if ($file === '-') {
    $json = stream_get_contents(STDIN);
} else {
    if (!is_file($file)) {
        fwrite(STDERR, "Erro: arquivo JSON não encontrado: {$file}\n");
        exit(2);
    }
    $json = file_get_contents($file);
}

// Valida JSON mínimo
if ($json === false || trim($json) === '') {
    fwrite(STDERR, "Erro: conteúdo JSON vazio.\n");
    exit(3);
}

json_decode($json);
if (json_last_error() !== JSON_ERROR_NONE) {
    fwrite(STDERR, "Erro: JSON inválido - " . json_last_error_msg() . "\n");
    exit(4);
}

// Se foi passado override de CNPJ, aplica antes do envio
if ($overrideCnpj) {
    $decoded = json_decode($json, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        // normaliza: remove pontuação
        $clean = preg_replace('/\D+/', '', $overrideCnpj);
        if (strlen($clean) === 14) {
            if (!isset($decoded['emit'])) {
                $decoded['emit'] = [];
            }
            $decoded['emit']['CNPJ'] = $clean;
            $json = json_encode($decoded, JSON_UNESCAPED_UNICODE);
            echo "Aplicado override emit.CNPJ = {$clean}\n";
        } else {
            fwrite(STDERR, "Aviso: CNPJ de override inválido (esperado 14 dígitos): {$overrideCnpj}\n");
        }
    } else {
        fwrite(STDERR, "Aviso: não foi possível decodificar JSON para aplicar override de CNPJ.\n");
    }
}

$url = $baseUrl . $endpoint;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
// Autenticação via HTTP Basic (token como usuário, senha vazia) conforme doc da Focus
curl_setopt($ch, CURLOPT_USERPWD, $token . ':');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

echo "Request URL: {$url}\n";
echo "HTTP Status: {$httpCode}\n";
if ($curlErr) {
    fwrite(STDERR, "cURL error: {$curlErr}\n");
}

// Tenta formatar saída JSON se possível
$decoded = json_decode($response, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
} else {
    echo $response . "\n";
}

exit(0);
