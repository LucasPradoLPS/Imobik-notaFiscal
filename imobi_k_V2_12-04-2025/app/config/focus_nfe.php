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

// Multi-ambiente: homolog e production
// Use a variável de ambiente FOCUS_ENV para selecionar: 'homolog' ou 'production'
// Observação: removemos o ambiente 'sandbox' — configure 'homolog' para testes de homologação.
return [
    'environment' => env('FOCUS_ENV') ?: 'homolog',
    'timeout' => (int)(env('FOCUS_NFE_TIMEOUT') ?: 30),
    'issuer_cnpj' => env('FOCUS_NFE_CNPJ') ?: '',
    'environments' => [
        'homolog' => [
            // Override with FOCUS_NFE_BASE_URL_HOMOLOG and FOCUS_NFE_TOKEN_HOMOLOG
            'base_url' => env('FOCUS_NFE_BASE_URL_HOMOLOG') ?: 'https://homologacao.focusnfe.com.br',
            'token'    => env('FOCUS_NFE_TOKEN_HOMOLOG') ?: 'tN7X5943azf7cgGbqmN6BL3BDZ52pVAm',
        ],
        'production' => [
            'base_url' => env('FOCUS_NFE_BASE_URL') ?: 'https://api.focusnfe.com.br',
            // Token de produção solicitado pelo usuário
            'token'    => env('FOCUS_NFE_TOKEN') ?: 'alpbFbNUFrnJLmgPbTtlXq4nhDnJN3AN',
        ],
    ],
];
