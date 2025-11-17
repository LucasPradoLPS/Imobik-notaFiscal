<?php
$cfg = include __DIR__ . '/../config/focus_nfe.php';
$env = $cfg['environment'] ?? 'homolog';
$envs = $cfg['environments'] ?? [];
$sel = isset($envs[$env]) ? $envs[$env] : (count($envs) ? reset($envs) : []);
echo "FOCUS_ENV=" . $env . "\n";
echo "Base URL=" . ($sel['base_url'] ?? '(vazio)') . "\n";
echo "Token prefix=" . (isset($sel['token']) && $sel['token'] !== '' ? substr($sel['token'],0,6) : '(vazio)') . "\n";
