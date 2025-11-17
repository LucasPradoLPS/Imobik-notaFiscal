<?php
// Simple session diagnostic
header('Content-Type: text/plain; charset=utf-8');
$path = session_save_path();
if (!$path) {
    $path = sys_get_temp_dir();
}
if (!is_dir($path)) {
    @mkdir($path, 0777, true);
}
session_start();
$_SESSION['diag_time'] = date('c');
$file = $path . '/sess_' . session_id();
$exists = file_exists($file) ? 'YES' : 'NO';
$size = $exists ? filesize($file) : 0;

echo "session_id=" . session_id() . "\n";
echo "save_path=" . $path . "\n";
echo "session_file_exists=" . $exists . " size=" . $size . "\n";
echo "cookie_sent=" . (isset($_COOKIE[session_name()]) ? 'YES' : 'NO') . "\n";
echo "_SESSION_count=" . count($_SESSION) . "\n";
