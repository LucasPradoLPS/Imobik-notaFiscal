<?php
libxml_use_internal_errors(true);
$s = file_get_contents(__DIR__ . '/../menu.xml');
$x = simplexml_load_string($s);
if($x === false) {
    foreach(libxml_get_errors() as $err) {
        echo trim($err->message) . " in line " . $err->line . "\n";
    }
    exit(1);
}
echo "OK\n";
