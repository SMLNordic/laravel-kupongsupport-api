<?php

return [
    'token' => env('KS_API_TOKEN'),
    'base_url' => env('KS_BASE_URL', 'https://kupongsupport.se'),

    'templates' => [
        'print' => env('KS_PRINT_TEMPLATE_ID'),
        'mobile' => env('KS_MOBILE_TEMPLATE_ID')
    ]
];
