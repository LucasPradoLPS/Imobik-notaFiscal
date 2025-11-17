<?php
// nfe_cli.php - Script de linha de comando para testar endpoints /v2/nfe via FocusNFeClient
// Uso: php nfe_cli.php <comando> [--ref=REF] [--xml=file.xml] [--data='json']
// Exemplos:
// php nfe_cli.php create --ref=meuref --xml=sample_nfe.xml
// php nfe_cli.php get --ref=meuref
// php nfe_cli.php delete --ref=meuref
// php nfe_cli.php carta_correcao --ref=meuref --data='{"texto":"Correção..."}'

// Ajuste o include_path conforme a sua estrutura; aqui usamos paths relativos ao workspace
$base = __DIR__ . '/../../';
require_once $base . 'app/service/FocusNFeClient.php';

// Carrega config (mesma lógica do app)
$cfgFile = $base . 'app/config/focus_nfe.php';
if (!file_exists($cfgFile)) {
    fwrite(STDERR, "Arquivo de config não encontrado: $cfgFile\n");
    exit(2);
}
$cfg = include $cfgFile;

// Resolve environment-specific base_url/token for homolog (ou usa environment padrão)
$env = $cfg['environment'] ?? 'sandbox';
$envs = $cfg['environments'] ?? [];
$selected = $envs[$env] ?? reset($envs);

$clientConfig = [
    'environment' => $env,
    'timeout' => $cfg['timeout'] ?? 30,
    'environments' => $envs,
];

try {
    $client = new FocusNFeClient($clientConfig);
} catch (Exception $e) {
    fwrite(STDERR, "Falha ao criar FocusNFeClient: " . $e->getMessage() . "\n");
    exit(3);
}

// Simple arg parsing
$argv0 = array_shift($argv);
$command = array_shift($argv) ?? '';
$params = [];
foreach ($argv as $a) {
    if (strpos($a, '--') === 0) {
        $p = substr($a, 2);
        $kv = explode('=', $p, 2);
        $k = $kv[0];
        $v = $kv[1] ?? true;
        $params[$k] = $v;
    }
}

function out($v) { echo json_encode($v, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n"; }

if (in_array($command, ['help', '-h', '--help', ''])) {
    echo "nfe_cli.php - comandos:\n";
    echo "  create --ref=REF [--xml=path]\n";
    echo "  get --ref=REF\n";
    echo "  delete --ref=REF\n";
    echo "  carta_correcao --ref=REF --data='JSON'\n";
    echo "  ator --ref=REF --data='JSON'\n";
    echo "  insucesso --ref=REF --data='JSON'\n";
    echo "  delete-insucesso --ref=REF\n";
    echo "  email --ref=REF --data='JSON'\n";
    echo "  inutilizar --data='JSON'\n";
    echo "  list-inutilizacoes [--query='k=v&...']\n";
    echo "  import --ref=REF --xml=path\n";
    echo "  danfe --data='JSON'\n";
    echo "  econf-register --ref=REF --data='JSON'\n";
    echo "  econf-get --ref=REF --numero=PROTOCOLO\n";
    echo "  econf-delete --ref=REF --numero=PROTOCOLO\n";
    exit(0);
}

try {
    switch ($command) {
        case 'create':
            $ref = $params['ref'] ?? 'ref' . bin2hex(random_bytes(6));
            $xmlFile = $params['xml'] ?? (__DIR__ . '/samples/sample_nfe.xml');
            if (!file_exists($xmlFile)) { fwrite(STDERR, "XML não encontrado: $xmlFile\n"); exit(4); }
            $xml = file_get_contents($xmlFile);
            $res = $client->sendInvoiceXml($xml, $ref);
            out($res);
            break;

        case 'get':
            $ref = $params['ref'] ?? null;
            if (!$ref) { fwrite(STDERR, "--ref é obrigatório\n"); exit(4); }
            out($client->getByReference($ref));
            break;

        case 'delete':
            $ref = $params['ref'] ?? null;
            if (!$ref) { fwrite(STDERR, "--ref é obrigatório\n"); exit(4); }
            out($client->deleteByReference($ref));
            break;

        case 'carta_correcao':
            $ref = $params['ref'] ?? null; if (!$ref) { fwrite(STDERR, "--ref é obrigatório\n"); exit(4); }
            $data = $params['data'] ?? null; if (!$data) { fwrite(STDERR, "--data é obrigatório (JSON)\n"); exit(4); }
            $payload = json_decode($data, true);
            out($client->createCartaCorrecao($ref, $payload));
            break;

        case 'ator':
            $ref = $params['ref'] ?? null; if (!$ref) { fwrite(STDERR, "--ref é obrigatório\n"); exit(4); }
            $payload = json_decode($params['data'] ?? '{}', true);
            out($client->addAtorInteressado($ref, $payload));
            break;

        case 'insucesso':
            $ref = $params['ref'] ?? null; if (!$ref) { fwrite(STDERR, "--ref é obrigatório\n"); exit(4); }
            $payload = json_decode($params['data'] ?? '{}', true);
            out($client->markInsucessoEntrega($ref, $payload));
            break;

        case 'delete-insucesso':
            $ref = $params['ref'] ?? null; if (!$ref) { fwrite(STDERR, "--ref é obrigatório\n"); exit(4); }
            out($client->deleteInsucessoEntrega($ref));
            break;

        case 'email':
            $ref = $params['ref'] ?? null; if (!$ref) { fwrite(STDERR, "--ref é obrigatório\n"); exit(4); }
            $payload = json_decode($params['data'] ?? '{}', true);
            out($client->sendEmailByReference($ref, $payload));
            break;

        case 'inutilizar':
            $payload = json_decode($params['data'] ?? '{}', true);
            out($client->inutilizacao($payload));
            break;

        case 'list-inutilizacoes':
            $query = [];
            if (!empty($params['query'])) {
                parse_str($params['query'], $query);
            }
            out($client->listInutilizacoes($query));
            break;

        case 'import':
            $ref = $params['ref'] ?? null; if (!$ref) { fwrite(STDERR, "--ref é obrigatório\n"); exit(4); }
            $xmlFile = $params['xml'] ?? (__DIR__ . '/samples/sample_nfe.xml');
            if (!file_exists($xmlFile)) { fwrite(STDERR, "XML não encontrado: $xmlFile\n"); exit(4); }
            $xml = file_get_contents($xmlFile);
            out($client->importacaoFromXml($ref, $xml));
            break;

        case 'danfe':
            $payload = json_decode($params['data'] ?? '{}', true);
            out($client->danfePreview($payload));
            break;

        case 'econf-register':
            $ref = $params['ref'] ?? null; if (!$ref) { fwrite(STDERR, "--ref é obrigatório\n"); exit(4); }
            $payload = json_decode($params['data'] ?? '{}', true);
            out($client->econfRegister($ref, $payload));
            break;

        case 'econf-get':
            $ref = $params['ref'] ?? null; $num = $params['numero'] ?? null; if (!$ref || !$num) { fwrite(STDERR, "--ref e --numero são obrigatórios\n"); exit(4); }
            out($client->econfGet($ref, $num));
            break;

        case 'econf-delete':
            $ref = $params['ref'] ?? null; $num = $params['numero'] ?? null; if (!$ref || !$num) { fwrite(STDERR, "--ref e --numero são obrigatórios\n"); exit(4); }
            out($client->econfDelete($ref, $num));
            break;

        default:
            fwrite(STDERR, "Comando desconhecido: $command\n");
            exit(5);
    }
} catch (Exception $e) {
    fwrite(STDERR, "Erro na requisição: " . $e->getMessage() . "\n");
    exit(6);
}

// EOF
