<?php

declare(strict_types=1);

return [
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
        'currency' => env('PAYPAL_CURRENCY'),
        'test_mode' => env('PAYPAL_TEST_MODE'),
    ],
];
