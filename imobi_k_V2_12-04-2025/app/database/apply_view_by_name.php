<?php
// apply_view_by_name.php
// Usage: php apply_view_by_name.php schema.viewname

if ($argc < 2) {
    fwrite(STDERR, "Uso: php apply_view_by_name.php schema.viewname\n");
    exit(2);
}
$target = $argv[1];
$sqlFile = __DIR__ . DIRECTORY_SEPARATOR . '03 creat_view.sql';
if (!file_exists($sqlFile)) { fwrite(STDERR, "SQL file not found: $sqlFile\n"); exit(3); }
$sql = file_get_contents($sqlFile);
if ($sql === false) { fwrite(STDERR, "Failed to read SQL file\n"); exit(4); }

// Regex to capture the CREATE VIEW ... AS ...; block for the exact view name
$pattern = '/CREATE\s+(?:OR\s+REPLACE\s+)?VIEW\s+' . preg_quote($target, '/') . '\s+AS\s+(.*?);\s*\n/si';
if (!preg_match($pattern, $sql, $m)) {
    fwrite(STDERR, "Não foi possível encontrar a definição de CREATE VIEW para: $target\n");
    // also show nearby lines to help manual inspection
    // try a broader search for the view name
    if (preg_match('/CREATE\s+(?:OR\s+REPLACE\s+)?VIEW\s+([^\s]+)\s+AS/si', $sql, $all)) {
        fwrite(STDERR, "Views encontradas (amostra): " . substr($sql,0,400) . "\n");
    }
    exit(5);
}
$createBody = $m[1];
$createStmt = "CREATE OR REPLACE VIEW $target AS\n" . $createBody . ";\n";

$config = include __DIR__ . '/../config/imobi_system.php';
$dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['name']}";
try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    echo "Aplicando view: $target\n";
    try {
        $pdo->exec("DROP VIEW IF EXISTS $target CASCADE");
        echo "DROP VIEW IF EXISTS $target CASCADE; OK\n";
    } catch (PDOException $e) {
        echo "DROP falhou: " . $e->getMessage() . "\n";
    }
    try {
        $pdo->exec($createStmt);
        echo "CREATE VIEW aplicado com sucesso.\n";
    } catch (PDOException $e) {
        fwrite(STDERR, "Falha ao criar view: " . $e->getMessage() . "\n");
        exit(6);
    }
    // Verifica existência via information_schema
    $parts = explode('.', $target, 2);
    $schema = $parts[0];
    $name = $parts[1];
    $row = $pdo->query("SELECT table_schema, table_name FROM information_schema.views WHERE table_schema = '".addslashes($schema)."' AND table_name = '".addslashes($name)."'")->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "Verificação: view encontrada em {$row['table_schema']}.{$row['table_name']}.\n";
        // try a sample select
        try {
            $sample = $pdo->query("SELECT * FROM $target LIMIT 1")->fetch(PDO::FETCH_NUM);
            if ($sample !== false) {
                echo "SELECT * FROM $target LIMIT 1 -> linha encontrada.\n";
            } else {
                echo "SELECT * FROM $target LIMIT 1 -> sem linhas, mas view existe.\n";
            }
        } catch (PDOException $e) {
            echo "SELECT de verificação falhou: " . $e->getMessage() . "\n";
        }
        exit(0);
    } else {
        fwrite(STDERR, "Verificação: view não encontrada em information_schema\n");
        exit(7);
    }
} catch (Exception $e) {
    fwrite(STDERR, "Erro de conexão: " . $e->getMessage() . "\n");
    exit(1);
}
