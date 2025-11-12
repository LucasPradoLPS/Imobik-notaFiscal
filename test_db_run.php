<?php
try {
    $dbh = new PDO('pgsql:host=localhost;port=5432;dbname=ontem_imobi','postgres','1234');
    echo "PG OK\n";
} catch (Exception $e) {
    echo "PG ERROR: " . $e->getMessage() . "\n";
}
