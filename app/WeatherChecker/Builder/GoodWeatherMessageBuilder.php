<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

class GoodWeatherMessageBuilder
{
    public function getMessage(string $startDate, string $endDate): string
    {
        $vars = compact('startDate', 'endDate');

        return __('weather-rules.success', $vars);
    }
}
