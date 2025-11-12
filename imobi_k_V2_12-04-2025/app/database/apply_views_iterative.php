<?php
// apply_views_iterative.php
// Iteratively apply all CREATE VIEW statements found in '03 creat_view.sql'
// Usage: php apply_views_iterative.php

$sqlFile = __DIR__ . DIRECTORY_SEPARATOR . '03 creat_view.sql';
if (!file_exists($sqlFile)) {
    fwrite(STDERR, "SQL file not found: $sqlFile\n");
    exit(2);
}
$sql = file_get_contents($sqlFile);
if ($sql === false) { fwrite(STDERR, "Failed to read SQL file\n"); exit(3); }

// extract CREATE VIEW blocks
$pattern = '/CREATE\s+(?:OR\s+REPLACE\s+)?VIEW\s+([^\s(]+)\s+AS\s+(.*?);\s*\n/si';
if (!preg_match_all($pattern, $sql, $matches, PREG_SET_ORDER)) {
    fwrite(STDERR, "No CREATE VIEW statements found in SQL file.\n");
    exit(4);
}
$views = [];
foreach ($matches as $m) {
    $name = $m[1];
    $body = $m[2];
    $create = "CREATE OR REPLACE VIEW $name AS\n" . $body . ";";
    $views[$name] = [
        'create' => $create,
        'applied' => false,
        'last_error' => null,
    ];
}

$config = include __DIR__ . '/../config/imobi_system.php';
$dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['name']}";
try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    fwrite(STDERR, "DB connection failed: " . $e->getMessage() . "\n");
    exit(5);
}

$max_passes = 10;
$pass = 0;
$applied_total = 0;

echo "Found " . count($views) . " views to process. Starting iterative apply (max $max_passes passes).\n";

while ($pass < $max_passes) {
    $pass++;
    echo "\n=== Pass $pass ===\n";
    $made_progress = false;

    foreach ($views as $name => &$meta) {
        if ($meta['applied']) continue;

        echo "Attempting: $name\n";
        // Try to drop first (safe)
        try {
            $pdo->exec("DROP VIEW IF EXISTS $name CASCADE");
        } catch (PDOException $e) {
            // non-fatal drop error, record but proceed to create attempt
            $meta['last_error'] = "DROP error: " . $e->getMessage();
        }

        try {
            $pdo->exec($meta['create']);
            $meta['applied'] = true;
            $meta['last_error'] = null;
            $applied_total++;
            $made_progress = true;
            echo "Applied: $name\n";
        } catch (PDOException $e) {
            $meta['last_error'] = $e->getMessage();
            echo "Failed: $name -> " . $e->getMessage() . "\n";
        }
    }
    unset($meta);

    if (!$made_progress) {
        echo "No progress in pass $pass; stopping early.\n";
        break;
    }

    // check if all applied
    $remaining = array_filter($views, function($v){ return !$v['applied']; });
    if (count($remaining) === 0) {
        echo "All views applied successfully in $pass pass(es).\n";
        break;
    } else {
        echo count($remaining) . " views remaining after pass $pass.\n";
    }
}

// summary
echo "\n=== Summary ===\n";
echo "Total views: " . count($views) . "\n";
echo "Applied: $applied_total\n";
$failed = array_filter($views, function($v){ return !$v['applied']; });
if (count($failed) > 0) {
    echo "Failed to apply " . count($failed) . " views:\n";
    foreach ($failed as $name => $meta) {
        echo "- $name : " . ($meta['last_error'] ?? 'unknown error') . "\n";
    }
    exit(6);
}

exit(0);
