<?php
// Configurações para Focus NFe API
// Substitua os valores abaixo pelos fornecidos pela Focus NFe
// Helper mínimo para obter variáveis de ambiente quando env() não existe
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

// Multi-ambiente: sandbox (homolog) e production
// Use a variável de ambiente FOCUS_ENV para selecionar: 'sandbox' ou 'production'
return [
    'environment' => env('FOCUS_ENV') ?: 'sandbox',
    'timeout' => (int)(env('FOCUS_NFE_TIMEOUT') ?: 30),
    'issuer_cnpj' => env('FOCUS_NFE_CNPJ') ?: '',
    'environments' => [
        // sandbox / homologation / production
        // Some providers use separate homologation endpoints; expose a 'homolog' entry so you can set FOCUS_ENV='homolog'
        'sandbox' => [
            'base_url' => env('FOCUS_NFE_BASE_URL_SANDBOX') ?: 'https://api-sandbox.focusnfe.com.br',
            'token'    => env('FOCUS_NFE_TOKEN_SANDBOX') ?: 'tN7X5943azf7cgGbqmN6BL3BDZ52pVAm',
        ],
        'homolog' => [
            // allow explicit override via FOCUS_NFE_BASE_URL_HOMOLOG / FOCUS_NFE_TOKEN_HOMOLOG
            // set default homolog endpoint as provided
            'base_url' => env('FOCUS_NFE_BASE_URL_HOMOLOG') ?: 'https://homologacao.focusnfe.com.br',
            'token'    => env('FOCUS_NFE_TOKEN_HOMOLOG') ?: env('FOCUS_NFE_TOKEN_SANDBOX') ?: '',
        ],
        'production' => [
            'base_url' => env('FOCUS_NFE_BASE_URL') ?: 'https://api.focusnfe.com.br',
            'token'    => env('FOCUS_NFE_TOKEN') ?: 'alpbFbNUFrnJLmgPbTtlXq4nhDnJN3AN',
        ],
    ],
];
