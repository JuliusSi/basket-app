<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

class GoodWeatherMessageBuilder
{
    public function getMessage(string $startDate, string $endDate, string $updatedAt): string
    {
        $vars = compact('startDate', 'endDate', 'updatedAt');

        return __('weather-rules.success', $vars);
    }
}
