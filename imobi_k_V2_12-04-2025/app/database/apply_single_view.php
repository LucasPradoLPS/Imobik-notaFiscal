<?php
// apply_single_view.php - apply only pessoa.pessoafull definition from 03 creat_view.sql
$sqlFile = __DIR__ . DIRECTORY_SEPARATOR . '03 creat_view.sql';
if (!file_exists($sqlFile)) { fwrite(STDERR, "SQL file not found\n"); exit(2); }
$sql = file_get_contents($sqlFile);
if ($sql === false) { fwrite(STDERR, "Failed to read SQL file\n"); exit(3); }

// Find the CREATE VIEW for pessoa.pessoafull (case-insensitive, dotall)
if (!preg_match('/CREATE\s+(?:OR\s+REPLACE\s+)?VIEW\s+(pessoa\.pessoafull)\s+AS\s+(.*?);\s*\n/si', $sql, $m)) {
    fwrite(STDERR, "Could not find pessoa.pessoafull CREATE VIEW statement in SQL file\n"); exit(4);
}
$viewName = $m[1];
$createStmt = "CREATE OR REPLACE VIEW $viewName AS\n" . $m[2] . ";\n";

$config = include __DIR__ . '/../config/imobi_system.php';
$dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['name']}";
try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    echo "Dropping view if exists: $viewName\n";
    try { $pdo->exec("DROP VIEW IF EXISTS $viewName CASCADE"); } catch (PDOException $e) { echo "Drop failed: " . $e->getMessage() . "\n"; }
    echo "Creating view: $viewName\n";
    $pdo->exec($createStmt);
    echo "Created. Verifying idpessoachar...\n";
    $row = $pdo->query('SELECT idpessoachar FROM pessoa.pessoafull LIMIT 1')->fetch(PDO::FETCH_NUM);
    if ($row !== false) { echo "idpessoachar sample: " . $row[0] . "\n"; exit(0); }
    echo "No rows returned but view created.\n";
    exit(0);
} catch (Exception $e) {
    fwrite(STDERR, "Error: " . $e->getMessage() . "\n");
    exit(1);
}
