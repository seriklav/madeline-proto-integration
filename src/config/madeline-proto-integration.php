<?php

declare(strict_types=1);

return [
    'url' => env('MADELINE_PROTO_INTEGRATION_URL'),
    'auth' => [
        'login' => env('MADELINE_PROTO_INTEGRATION_AUTH_LOGIN'),
        'password' => env('MADELINE_PROTO_INTEGRATION_AUTH_PASSWORD'),
    ],
];
