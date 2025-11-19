<?php
if (version_compare(PHP_VERSION, '7.4.0') == -1)
{
    die ('The minimum version required for PHP is 7.4.0');
}

// try to locate application.ini in current working dir first, then relative to this file
$iniPath = 'app/config/application.ini';
if (!file_exists($iniPath))
{
    $iniPath = __DIR__ . '/app/config/application.ini';
}
if (!file_exists($iniPath))
{
    die('Application configuration file not found');
}

// ensure the working directory is the application folder so relative paths resolve
chdir(__DIR__);

ini_set('error_log', 'tmp/php_errors.log');


// define the autoloader (use paths relative to this file to be robust)
$loader = require __DIR__ . '/vendor/autoload.php';
$loader->register();

require_once __DIR__ . '/lib/adianti/core/AdiantiCoreLoader.php';
spl_autoload_register(array('Adianti\\Core\\AdiantiCoreLoader', 'autoload'));
Adianti\Core\AdiantiCoreLoader::loadClassMap();

// read configurations
$ini = parse_ini_file($iniPath, true);
date_default_timezone_set($ini['general']['timezone']);
AdiantiCoreTranslator::setLanguage( $ini['general']['language'] );
ApplicationTranslator::setLanguage( $ini['general']['language'] );
BuilderTranslator::setLanguage( $ini['general']['language'] );
AdiantiApplicationConfig::load($ini);
AdiantiApplicationConfig::apply();

// define constants
define('APPLICATION_NAME', $ini['general']['application']);
define('OS', strtoupper(substr(PHP_OS, 0, 3)));
define('PATH', dirname(__FILE__));
define('LANG', $ini['general']['language']);
define('MAIN_DATABASE', $ini['general']['main_database'] ?? '');
define('APPLICATION_VERSION', $ini['general']['application_version'] ?? '');

// custom session name
session_name('PHPSESSID_'.$ini['general']['application']);

setlocale(LC_ALL, 'C');

// ensure application-specific session directory to avoid loop on login
$sessionDir = __DIR__ . '/tmp/sessions';
if (!is_dir($sessionDir)) {
    @mkdir($sessionDir, 0777, true);
}
if (is_dir($sessionDir) && is_writable($sessionDir)) {
    session_save_path($sessionDir);
}

// carregar explicitamente a CrmView (caso autoloader ainda não enxergue nova classe)
$crmViewPath = __DIR__ . '/app/control/imobiliaria/CrmView.php';
if (file_exists($crmViewPath)) {
    require_once $crmViewPath;
}
// carregar explicitamente o proxy CRM (diretório service pode não estar no autoload padrão)
$crmProxyPath = __DIR__ . '/app/service/EspoCrmProxy.php';
if (file_exists($crmProxyPath)) {
    require_once $crmProxyPath;
}

// Lightweight .env loader: loads KEY=VALUE pairs if not already provided by environment
// Allows inline comments after value using '#'. Quotes around values are stripped.
// This runs once at bootstrap; explicit environment always overrides .env.
(function () {
    $envFile = __DIR__ . DIRECTORY_SEPARATOR . '.env';
    if (!is_file($envFile)) {
        return;
    }
    $lines = @file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }
    foreach ($lines as $line) {
        // Strip potential UTF-8 BOM from start of file/line
        if (strncmp($line, "\xEF\xBB\xBF", 3) === 0) {
            $line = substr($line, 3);
        }
        $line = trim($line ?? '');
        if ($line === '' || $line[0] === '#' ) {
            continue;
        }
        // Remove inline comment portion
        $line = preg_replace('/\s+#.*$/', '', $line);
        $eq = strpos($line, '=');
        if ($eq === false) {
            continue;
        }
        $key = trim(substr($line, 0, $eq));
        // Also strip BOM from key just in case
        if (strncmp($key, "\xEF\xBB\xBF", 3) === 0) {
            $key = substr($key, 3);
        }
        $val = trim(substr($line, $eq + 1));
        if ($key === '') {
            continue;
        }
        // Strip surrounding quotes
        if ((str_starts_with($val, '"') && str_ends_with($val, '"')) || (str_starts_with($val, "'") && str_ends_with($val, "'"))) {
            $val = substr($val, 1, -1);
        }
        $current = getenv($key);
        if ($current === false || $current === '') {
            putenv("$key=$val");
            $_ENV[$key] = $val;
            $_SERVER[$key] = $val;
        }
    }
})();

