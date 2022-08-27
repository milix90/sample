<?php

return [
    'ttl' => [
        'verify' => env('REDIS_TTL_VERIFY_ACCOUNT', 60),
        'reset' => env('REDIS_TTL_RESET_PASSWORD', 60),
    ],
];
