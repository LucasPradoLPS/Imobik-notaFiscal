<?php
// CRM configuration file.
// Fallback precedence: environment variables override these values.
return [
    'base_url' => getenv('CRM_BASE_URL') ?: 'https://SEU_ESPOCRM_BASE_URL',
    'api_key'  => getenv('CRM_API_KEY') ?: 'COLOQUE_API_KEY_AQUI'
];