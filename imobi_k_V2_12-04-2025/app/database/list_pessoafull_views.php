<?php
$config = include __DIR__ . '/../config/imobi_system.php';
$dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['name']}";
try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $sql = "SELECT table_schema, table_name, view_definition FROM information_schema.views WHERE table_name = 'pessoafull' OR table_name = 'pessoafull'";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) {
        echo "No views named 'pessoafull' found.\n";
    } else {
        foreach ($rows as $r) {
            echo "schema: {$r['table_schema']}, name: {$r['table_name']}\n";
            echo "definition (first 400 chars):\n" . substr($r['view_definition'] ?? '',0,400) . "\n---\n";
        }
    }
} catch (Exception $e) {
    fwrite(STDERR, "Error: " . $e->getMessage() . "\n");
    exit(1);
}
