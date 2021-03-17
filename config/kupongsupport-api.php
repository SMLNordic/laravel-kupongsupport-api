<?php

return [
    'api_token' => env('KS_API_TOKEN'),
    'base_url' => 'https://kupongsupport.se',

    'templates' => [
        'print' => env('KS_PRINT_TEMPLATE_ID'),
        'mobile' => env('KS_MOBILE_TEMPLATE_ID')
    ]
];
