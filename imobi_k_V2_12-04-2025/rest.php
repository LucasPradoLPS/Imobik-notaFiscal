<?php
header('Content-Type: application/json; charset=utf-8');

// --- Early instrumentation: capture uncaught exceptions and fatal errors to tmp/php_errors.log ---
$earlyLogFile = __DIR__ . '/../tmp/php_errors.log';
if (!file_exists(dirname($earlyLogFile))) {
    @mkdir(dirname($earlyLogFile), 0755, true);
}

set_exception_handler(function($e) use ($earlyLogFile) {
    $msg = date('c') . " EARLY EXCEPTION: " . strval($e->getMessage()) . "\n";
    if (method_exists($e, 'getTraceAsString')) {
        $msg .= $e->getTraceAsString() . "\n";
    }
    @file_put_contents($earlyLogFile, $msg . "\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode(['status' => 'error', 'data' => strval($e->getMessage())]);
    exit;
});

register_shutdown_function(function() use ($earlyLogFile) {
    $err = error_get_last();
    if ($err !== null) {
        $msg = date('c') . " EARLY FATAL: " . print_r($err, true) . "\n";
        @file_put_contents($earlyLogFile, $msg, FILE_APPEND);
    }
});

// initialization script
require_once 'init.php';

// --- Instrumentation: capture uncaught exceptions and fatal errors to tmp/php_errors.log ---
$logFile = __DIR__ . '/../tmp/php_errors.log';
if (!file_exists(dirname($logFile))) {
    @mkdir(dirname($logFile), 0755, true);
}

function imobi_log_exception($e)
{
    global $logFile;
    $msg = date('c') . " EXCEPTION: " . strval($e->getMessage()) . "\n";
    if (method_exists($e, 'getTraceAsString')) {
        $msg .= $e->getTraceAsString() . "\n";
    }
    @file_put_contents($logFile, $msg . "\n", FILE_APPEND);
}

set_exception_handler(function($e) {
    imobi_log_exception($e);
    http_response_code(500);
    echo json_encode(['status' => 'error', 'data' => strval($e->getMessage())]);
    exit;
});

set_error_handler(function($severity, $message, $file, $line) {
    global $logFile;
    $msg = date('c') . " ERROR: {$message} in {$file}:{$line}\n";
    @file_put_contents($logFile, $msg, FILE_APPEND);
    // Let PHP internal handler run as well
    return false;
});

register_shutdown_function(function() {
    global $logFile;
    $err = error_get_last();
    if ($err !== null) {
        $msg = date('c') . " FATAL: " . print_r($err, true) . "\n";
        @file_put_contents($logFile, $msg, FILE_APPEND);
    }
});

// --- end instrumentation ---

class AdiantiRestServer
{
    public static function run($request)
    {
        $ini      = AdiantiApplicationConfig::get();
        $input    = json_decode(file_get_contents("php://input"), true);
        $request  = array_merge($request, (array) $input);
        $class    = isset($request['class']) ? $request['class']   : '';
        $method   = isset($request['method']) ? $request['method'] : '';
        $headers  = AdiantiCoreApplication::getHeaders();
        $response = NULL;
        
        $headers['Authorization'] = $headers['Authorization'] ?? ($headers['authorization'] ?? null); // for clientes that send in lowercase (Ex. futter)
        
        try
        {
            if (empty($headers['Authorization']))
            {
                throw new Exception( _t('Authorization error') );
            }
            else
            {
                if (substr($headers['Authorization'], 0, 5) == 'Basic')
                {
                    if (empty($ini['general']['rest_key']))
                    {
                        throw new Exception( _t('REST key not defined') );
                    }
					
                    if ($ini['general']['rest_key'] !== substr($headers['Authorization'], 6))
                    {
                        http_response_code(401);
                        return json_encode( array('status' => 'error', 'data' => _t('Authorization error')));
                    }
                }
                else if (substr($headers['Authorization'], 0, 6) == 'Bearer')
                {
                    ApplicationAuthenticationService::fromToken( substr($headers['Authorization'], 7) );
                }
                else
                {
                    http_response_code(403);
                    throw new Exception( _t('Authorization error') );
                }
            }
            
            $response = AdiantiCoreApplication::execute($class, $method, $request, 'rest');
            if (is_array($response))
            {
                array_walk_recursive($response, ['AdiantiStringConversion', 'assureUnicode']);
            }
            return json_encode( array('status' => 'success', 'data' => $response));
        }
        catch (Exception $e)
        {
            if (function_exists('imobi_log_exception')) {
                imobi_log_exception($e);
            }
            if(200 === http_response_code())
            {
                http_response_code(500);
            }

            return json_encode( array('status' => 'error', 'data' => $e->getMessage()));
        }
        catch (Error $e)
        {
            if (function_exists('imobi_log_exception')) {
                imobi_log_exception($e);
            }
            if(200 === http_response_code())
            {
                http_response_code(500);
            }

            return json_encode( array('status' => 'error', 'data' => $e->getMessage()));
        }
    }
}

print AdiantiRestServer::run($_REQUEST);
