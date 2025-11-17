<?php
// Configuração mínima para EspoCRM
if (! function_exists('env')) {
    function env(string $key, $default = null)
    {
        $val = getenv($key);
        if ($val === false || $val === null) {
            if (isset($_SERVER[$key])) {
                $val = $_SERVER[$key];
            } elseif (isset($_ENV[$key])) {
                $val = $_ENV[$key];
            } else {
                $val = $default;
            }
        }
        return $val;
    }
}

return [
    // EspoCRM configuration is read from environment variables.
    // Do NOT hardcode secrets here. Set in your shell or system env:
    //   ESPOCRM_BASE_URL, ESPOCRM_API_KEY, ESPOCRM_AUTH_TYPE
    'base_url' => env('ESPOCRM_BASE_URL') ?: null,
    'api_key'  => env('ESPOCRM_API_KEY') ?: null,
    // auth_type: 'bearer' or 'apikey' (default apikey)
    'auth_type' => env('ESPOCRM_AUTH_TYPE') ?: 'apikey',
    // optional webhook token to protect incoming webhooks
    'webhook_token' => env('ESPOCRM_WEBHOOK_TOKEN') ?: null,
];
