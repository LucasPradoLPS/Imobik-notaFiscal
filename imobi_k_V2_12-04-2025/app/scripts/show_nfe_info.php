<?php
// show_nfe_info.php - extrai CNPJ do XML de exemplo e mostra configuração efetiva do Focus NFe
$xmlFile = __DIR__ . '/samples/sample_nfe.xml';
if (!file_exists($xmlFile)) {
    echo "XML de exemplo não encontrado: $xmlFile\n";
    exit(1);
}

$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->load($xmlFile);
$xpath = new DOMXPath($doc);

// Encontrar CNPJ do emitente
$emitCnpjNodes = $xpath->query("//*[local-name()='emit']/*[local-name()='CNPJ']");
$emitCnpj = ($emitCnpjNodes->length > 0) ? trim($emitCnpjNodes->item(0)->nodeValue ?? '') : '(não encontrado)';

// Encontrar CNPJ/CPF do destinatário
$destCnpjNodes = $xpath->query("//*[local-name()='dest']/*[local-name()='CNPJ' or local-name()='CPF']");
$destId = ($destCnpjNodes->length > 0) ? trim($destCnpjNodes->item(0)->nodeValue ?? '') : '(não encontrado)';

echo "Emitente CNPJ: " . $emitCnpj . "\n";
echo "Destinatário CNPJ/CPF: " . $destId . "\n\n";

// Ler config
$configFile = __DIR__ . '/../config/focus_nfe.php';
if (!file_exists($configFile)) {
    echo "Config focus_nfe.php não encontrado: $configFile\n";
    exit(1);
}
$cfg = include $configFile;
$env = $cfg['environment'] ?? 'homolog';
$envs = $cfg['environments'] ?? [];
$sel = isset($envs[$env]) ? $envs[$env] : (count($envs) ? reset($envs) : []);

echo "Config environment: " . $env . "\n";
echo "Config base_url: " . ($sel['base_url'] ?? '(vazio)') . "\n";
echo "Config issuer_cnpj: " . ($cfg['issuer_cnpj'] ?? '(vazio)') . "\n";
echo "Token prefix (12 chars): " . (isset($sel['token']) && $sel['token'] !== '' ? substr($sel['token'],0,12) : '(vazio)') . "\n";
