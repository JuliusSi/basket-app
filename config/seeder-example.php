<?php

return [
    'user' => [
        'username' => 'dummy',
        'email' => 'dummy@gmail.com',
        'password' => 'dummypassword',
        'image_path' => 'img/robot.png',
    ],
    'role' => [
        'name' => 'logs',
        'description' => 'access logs',
    ],
    'basketball_courts' => [
        [
            'name' => 'Basketball court example',
            'description' => 'Basketball court description',
            'city' => 'Vilnius',
            'address' => 'Konstitucijos pr. 16, LT-09308, Vilniaus m. sav.',
            'image_path' => env('APP_URL') . '/storage/courts/court.jpg',
            'place_code' => 'vilnius',
        ],
        [
            'name' => 'Basketball court example2',
            'description' => 'Basketball court description',
            'city' => 'Vilnius',
            'address' => 'Konstitucijos pr. 16, LT-09308, Vilniaus m. sav.',
            'image_path' => env('APP_URL') . '/storage/courts/court.jpg',
            'place_code' => 'vilnius',
        ],
    ],
];
