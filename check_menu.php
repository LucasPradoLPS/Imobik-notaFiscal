<?php
libxml_use_internal_errors(true);
$s = file_get_contents('C:\\Users\\lucas\\Downloads\\imobi-k\\imobi_k_V2_12-04-2025\\menu.xml');
$xml = simplexml_load_string($s);
if(!$xml){ foreach(libxml_get_errors() as $e){ echo $e->message . PHP_EOL; } } else { echo "OK" . PHP_EOL; }

?>