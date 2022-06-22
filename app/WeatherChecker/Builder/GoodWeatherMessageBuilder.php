<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

class GoodWeatherMessageBuilder
{
    private const NEW_LINE = "\n";

    public function getMessage(string $startDate, string $endDate, string $updatedAt): string
    {
        $vars = compact('startDate', 'endDate', 'updatedAt');

        return __('weather-rules.success', $vars);
    }

    public function getFacebookMessage(string $startDate, string $endDate, string $updatedAt): string
    {
        $vars = compact('startDate', 'endDate');
        $checkIcon = html_entity_decode('&#9989;');
        $eyesEmoji = html_entity_decode('&#128064;');

        return sprintf(
            '%s %s %s%s %s: %s',
            $checkIcon,
            __('weather-rules.success', $vars),
            self::NEW_LINE,
            $eyesEmoji,
            __('main.updated'),
            $updatedAt
        );
    }
}
