<?php
/**
 * emit_and_persist.php
 *
 * Script de teste que executa o fluxo de emissão de NF-e usando FocusNFeClient
 * e persiste o resultado diretamente na tabela financeiro.faturaresponse via PDO.
 *
 * Uso (temporário):
 *   $env:FOCUS_NFE_BASE_URL_SANDBOX='http://localhost:8081'
 *   $env:FOCUS_ENV='sandbox'
 *   php emit_and_persist.php
 */

require_once __DIR__ . '/../service/FocusNFeClient.php';

$focusConf = include __DIR__ . '/../config/focus_nfe.php';
$dbConf = include __DIR__ . '/../config/imobi_system.php';

// ensure sample XML exists
$samplePath = __DIR__ . '/samples/sample_nfe.xml';
if (!file_exists($samplePath)) {
    echo "sample_nfe.xml not found in app/scripts/samples.\n";
    exit(1);
}

// build client
try {
    $client = new FocusNFeClient($focusConf);
} catch (Exception $e) {
    echo "Erro ao criar FocusNFeClient: " . $e->getMessage() . "\n";
    exit(2);
}

$xml = file_get_contents($samplePath);
echo "Enviando XML para: " . ($focusConf['environments'][$focusConf['environment']]['base_url'] ?? $focusConf['environments']['sandbox']['base_url']) . "\n";
try {
    $res = $client->sendInvoiceXml($xml);
} catch (Exception $e) {
    echo "Erro ao enviar XML: " . $e->getMessage() . "\n";
    exit(3);
}

echo "Resposta HTTP: " . ($res['status'] ?? 'n/a') . "\n";
if (!empty($res['json'])) {
    print_r($res['json']);
}

// prepare record to persist
$nfe_chave = null;
$nfe_protocolo = null;
$nfe_status = null;
$nfe_response_json = null;
if (!empty($res['json']) && is_array($res['json'])) {
    $nfe_chave = $res['json']['chave'] ?? null;
    $nfe_protocolo = $res['json']['nProt'] ?? $res['json']['protocolo'] ?? null;
    $nfe_status = $res['json']['status'] ?? null;
    $nfe_response_json = json_encode($res['json']);
} else {
    $nfe_response_json = $res['body'] ?? null;
    if (preg_match('/"chave"\s*[:=]\s*"?(\d{44})"?/i', $res['body'] ?? '', $m)) {
        $nfe_chave = $m[1];
    }
}

// enforce column length limits to avoid SQL errors
if (!empty($nfe_chave)) {
    // keep only digits and use last 44 characters if longer
    $digits = preg_replace('/\D/', '', $nfe_chave);
    if (strlen($digits) > 44) {
        $digits = substr($digits, -44);
        echo "Aviso: chave NFe maior que 44 caracteres, truncando para os últimos 44 dígitos: {$digits}\n";
    }
    $nfe_chave = $digits;
}
if (!empty($nfe_protocolo) && strlen($nfe_protocolo) > 128) {
    $nfe_protocolo = substr($nfe_protocolo, 0, 128);
}
if (!empty($nfe_status) && strlen($nfe_status) > 64) {
    $nfe_status = substr($nfe_status, 0, 64);
}

// save XML file
$storageDir = __DIR__ . '/../../files/nfe/';
if (!is_dir($storageDir)) {
    @mkdir($storageDir, 0755, true);
}
$filename = 'nfe_' . date('YmdHis') . '.xml';
$xmlPath = $storageDir . $filename;
file_put_contents($xmlPath, $xml);
$xmlRelPath = 'files/nfe/' . $filename;

// persist in DB using imobi_system.php config
$host = $dbConf['host'] ?? 'localhost';
$port = $dbConf['port'] ?? 5432;
$dbname = $dbConf['name'] ?? $dbConf['dbname'] ?? null;
$user = $dbConf['user'] ?? $dbConf['username'] ?? null;
$pass = $dbConf['pass'] ?? null;

if (empty($dbname) || empty($user)) {
    echo "DB config incomplete in app/config/imobi_system.php\n";
    exit(4);
}

$dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $host, $port, $dbname);
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo "Falha ao conectar ao DB: " . $e->getMessage() . "\n";
    exit(5);
}

$now = date('Y-m-d H:i:s');
$stmt = $pdo->prepare("INSERT INTO financeiro.faturaresponse (idfatura, nfe_chave, nfe_protocolo, nfe_status, nfe_response_json, nfe_xml_path, nfe_created_at, nfe_updated_at) VALUES (:idfatura, :nfe_chave, :nfe_protocolo, :nfe_status, :nfe_response_json, :nfe_xml_path, :created_at, :updated_at) RETURNING idfaturaresponse");
$idfatura = null; // not linking to a fatura in this test
$stmt->bindValue(':idfatura', $idfatura, PDO::PARAM_NULL);
$stmt->bindValue(':nfe_chave', $nfe_chave, PDO::PARAM_STR);
$stmt->bindValue(':nfe_protocolo', $nfe_protocolo, PDO::PARAM_STR);
$stmt->bindValue(':nfe_status', $nfe_status, PDO::PARAM_STR);
$stmt->bindValue(':nfe_response_json', $nfe_response_json, PDO::PARAM_STR);
$stmt->bindValue(':nfe_xml_path', $xmlRelPath, PDO::PARAM_STR);
$stmt->bindValue(':created_at', $now, PDO::PARAM_STR);
$stmt->bindValue(':updated_at', $now, PDO::PARAM_STR);

try {
    $stmt->execute();
    $inserted = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Persistido idfaturaresponse: " . ($inserted['idfaturaresponse'] ?? '(unknown)') . "\n";
    // fetch the inserted row for display
    $id = $inserted['idfaturaresponse'] ?? null;
    if ($id) {
        $q = $pdo->prepare('SELECT * FROM financeiro.faturaresponse WHERE idfaturaresponse = :id');
        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->execute();
        $row = $q->fetch(PDO::FETCH_ASSOC);
        print_r($row);
    }
} catch (PDOException $e) {
    echo "Erro ao persistir registro: " . $e->getMessage() . "\n";
    exit(6);
}

echo "Fluxo de emissão e persistência concluído.\n";
