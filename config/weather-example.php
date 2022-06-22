<?php

return [
    'rules' => [
        'max_precipitation' => 0,
        'max_past_precipitation' => 0.2,
        'max_air_temperature' => 26,
        'min_air_temperature' => 14,
        'min_air_temperature_if_clear' => 11,
        'min_air_temperature_if_clear_if_slow_wind' => 8,
        'max_air_temperature_if_clear_if_slow_wind' => 24,
        'min_air_temperature_to_check_humidity' => 18,
        'slow_wind_speed' => 4,
        'hours_to_check' => 4,
        'max_wind_speed' => 8,
        'max_wind_gust' => 12,
        'max_humidity' => 60,
    ],
    'available_places' => [
        'vilnius' => 'Vilnius',
    ],
];
