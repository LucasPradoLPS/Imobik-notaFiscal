<?php
/**
 * apply_migration.php
 *
 * Small helper to apply a SQL migration file to a Postgres database using PDO.
 * Usage (preferred): set environment variables PGHOST, PGUSER, PGPASSWORD, PGDATABASE (optional PGPORT)
 *   php apply_migration.php --file="app/scripts/migrations/alter_faturaresponse_add_nfe.sql"
 *
 * Or pass CLI options:
 *   php apply_migration.php --file=path/to.sql --host=localhost --user=me --pass=secret --db=mydb --port=5432
 */

$opts = getopt('', ['file:', 'host::', 'port::', 'user::', 'pass::', 'db::']);

$file = $opts['file'] ?? getenv('MIGRATION_FILE') ?? __DIR__ . '/migrations/alter_faturaresponse_add_nfe.sql';
$host = $opts['host'] ?? getenv('PGHOST');
$port = $opts['port'] ?? getenv('PGPORT') ?: 5432;
$user = $opts['user'] ?? getenv('PGUSER');
$pass = $opts['pass'] ?? getenv('PGPASSWORD');
$db   = $opts['db']   ?? getenv('PGDATABASE');

if (!file_exists($file)) {
    fwrite(STDERR, "Migration file not found: {$file}\n");
    exit(2);
}

if (empty($host) || empty($user) || empty($db)) {
    fwrite(STDERR, "Database connection parameters missing.\nProvide via env vars PGHOST, PGUSER, PGPASSWORD, PGDATABASE or via CLI options --host, --user, --pass, --db.\n");
    exit(3);
}

$sql = file_get_contents($file);
if ($sql === false) {
    fwrite(STDERR, "Failed to read SQL file: {$file}\n");
    exit(4);
}

echo "Applying migration: {$file}\n";
echo "Connecting to {$host}:{$port} database {$db} as {$user}\n";

$dsn = "pgsql:host={$host};port={$port};dbname={$db}";
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    // execute
    $pdo->exec($sql);
    echo "Migration applied successfully.\n";
    exit(0);
} catch (PDOException $e) {
    fwrite(STDERR, "Migration failed: " . $e->getMessage() . "\n");
    exit(1);
}
