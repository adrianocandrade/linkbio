<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['*'],

    'allowed_methods' => ['*'],

    // ✅ Segurança: Restringir origens permitidas (configurável via .env)
    'allowed_origins' => env('CORS_ALLOWED_ORIGINS') 
        ? explode(',', env('CORS_ALLOWED_ORIGINS'))
        : ['*'],  // Fallback para desenvolvimento

    'allowed_origins_patterns' => env('CORS_ALLOWED_ORIGINS_PATTERNS')
        ? [env('CORS_ALLOWED_ORIGINS_PATTERNS')]
        : [],

    'allowed_headers' => [
        '*',
        'Content-Type',
        'X-Auth-Token',
        'Origin',
        'Authorization',
        'Access-Control-Allow-Origin',
    ],

    'exposed_headers' => false,

    'max_age' => false,

    'supports_credentials' => true,

];
