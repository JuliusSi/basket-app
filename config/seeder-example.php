<?php

return [
    'user' => [
        'username' => 'dummy',
        'email' => 'dummy@gmail.com',
        'password' => 'dummypassword',
        'image_path' => 'img/robot.png',
    ],
    'roles' => [
        [
            'name' => 'sms_notifications',
            'description' => 'Ability to receive sms messages',
        ],
    ],
    'user_attributes' => [
        [
            'name' => 'notify_about_weather_for_basketball_by_sms',
            'value' => '0',
        ],
        [
            'name' => \App\Model\UserAttribute::NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_PLACE_CODE,
            'value' => 'vilnius',
        ],
        [
            'name' => 'weather_for_basketball_notification_time',
            'value' => '15:01',
        ],
    ],
    'basketball_courts' => [
        [
            'name' => 'Basketball court example',
            'description' => 'Basketball court description',
            'city' => 'Vilnius',
            'address' => 'Konstitucijos pr. 16, LT-09308, Vilniaus m. sav.',
            'image_path' => env('APP_URL').'/storage/courts/court.jpg',
            'place_code' => 'vilnius',
        ],
        [
            'name' => 'Basketball court example2',
            'description' => 'Basketball court description',
            'city' => 'Vilnius',
            'address' => 'Konstitucijos pr. 16, LT-09308, Vilniaus m. sav.',
            'image_path' => env('APP_URL').'/storage/courts/court.jpg',
            'place_code' => 'vilnius',
        ],
    ],
];
