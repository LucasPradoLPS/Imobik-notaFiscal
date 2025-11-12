<?php
// apply_views.php
// Executes the SQL in '03 creat_view.sql' using PDO and verifies the idpessoachar column.

$sqlFile = __DIR__ . DIRECTORY_SEPARATOR . '03 creat_view.sql';
if (!file_exists($sqlFile)) {
    fwrite(STDERR, "SQL file not found: $sqlFile\n");
    exit(2);
}

// load DB config from app/config/imobi_system.php
$configFile = __DIR__ . '/../config/imobi_system.php';
if (!file_exists($configFile)) {
    fwrite(STDERR, "Config file not found: $configFile\n");
    exit(3);
}

$config = include $configFile;
$host = $config['host'] ?? 'localhost';
$port = $config['port'] ?? '5432';
$dbname = $config['name'] ?? '';
$user = $config['user'] ?? '';
$pass = $config['pass'] ?? '';
$type = $config['type'] ?? 'pgsql';

try {
    if (stripos($type, 'pgsql') !== false) {
        $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    } elseif (stripos($type, 'mysql') !== false) {
        $dsn = "mysql:host={$host};port={$port};dbname={$dbname}";
    } else {
        fwrite(STDERR, "Unsupported DB type: {$type}\n");
        exit(4);
    }

    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        fwrite(STDERR, "Failed to read SQL file: $sqlFile\n");
        exit(5);
    }

    // We'll process CREATE VIEW blocks first (they can contain internal semicolons)
    // then execute the remaining statements splitted by semicolon.
    echo "Executing SQL from: $sqlFile\n";

    // Find all CREATE VIEW ... AS ... blocks. We look for 'CREATE [OR REPLACE] VIEW <name> AS' and capture
    // until the next 'CREATE ... VIEW' or end of file. This avoids breaking when the view body contains semicolons
    // (for example in nested DO blocks or functions).
    $viewPattern = '/CREATE\s+(?:OR\s+REPLACE\s+)?VIEW\s+([^\s(]+)\s+AS\s+(.*?)(?=(?:\r?\n\s*CREATE\s+(?:OR\s+REPLACE\s+)?VIEW)|\z)/is';
    preg_match_all($viewPattern, $sql, $viewMatches, PREG_SET_ORDER);

    $consumed = [];
    foreach ($viewMatches as $vm) {
        $viewName = $vm[1];
        $viewBody = $vm[2];

        // mark this exact match as consumed so we can remove from $sql later
        $consumed[] = $vm[0];

        try {
            echo "Dropping view if exists: $viewName\n";
            $pdo->exec("DROP VIEW IF EXISTS $viewName CASCADE");
        } catch (PDOException $e3) {
            echo "Drop view failed: " . $e3->getMessage() . "\n";
        }

        // Recreate the view using CREATE OR REPLACE VIEW to be safer
        $createSql = "CREATE OR REPLACE VIEW $viewName AS\n" . $viewBody;
        try {
            $pdo->exec($createSql);
            echo "Created view: $viewName\n";
        } catch (PDOException $e2) {
            echo "Create view failed: " . $e2->getMessage() . "\nView: " . substr($createSql,0,200) . "...\n";
        }
    }

    // Remove the consumed view blocks from the SQL so we can execute the remaining statements safely
    foreach ($consumed as $c) {
        $sql = str_replace($c, "", $sql);
    }

    // Now split remaining SQL by semicolon and execute each statement
    $parts = preg_split('/;\s*(?:\r?\n|$)/', $sql);
    foreach ($parts as $part) {
        $stmt = trim($part);
        if ($stmt === '') continue;

        try {
            $pdo->exec($stmt);
            echo "Executed statement.\n";
        } catch (PDOException $e2) {
            echo "Statement failed: " . $e2->getMessage() . "\nStatement: " . substr($stmt,0,200) . "...\n";
        }
    }

    // Verify existence of idpessoachar
    echo "Verifying view column 'idpessoachar'...\n";
    try {
        $row = $pdo->query('SELECT idpessoachar FROM pessoa.pessoafull LIMIT 1')->fetch(PDO::FETCH_NUM);
        if ($row !== false) {
            echo "Verification OK: idpessoachar exists. Sample value: " . $row[0] . "\n";
            exit(0);
        } else {
            echo "Verification: query returned no rows, but view exists.\n";
            exit(0);
        }
    } catch (PDOException $e) {
        fwrite(STDERR, "Verification failed: " . $e->getMessage() . "\n");
        exit(6);
    }

} catch (Exception $ex) {
    fwrite(STDERR, "Unexpected error: " . $ex->getMessage() . "\n");
    exit(10);
}
