<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

use App\WeatherChecker\Model\Response\WeatherResponse;

class GoodWeatherMessageBuilder
{
    private const NEW_LINE = "\n";

    public function __construct(private readonly WeatherSummaryBuilder $summaryBuilder)
    {
    }

    public function getMessage(string $startDate, string $endDate, string $updatedAt): string
    {
        $vars = compact('startDate', 'endDate', 'updatedAt');

        return __('weather-rules.success', $vars);
    }

    public function getFacebookMessage(WeatherResponse $response): string
    {
        $startDate = $response->getCheckedFrom()->format('H:i');
        $endDate = $response->getCheckedTo()->format('H:i');
        $updatedAt = $response->getMeasuredAt()->format('H:i');
        $vars = compact('startDate', 'endDate');
        $checkIcon = html_entity_decode('&#9989;');
        $eyesEmoji = html_entity_decode('&#128064;');
        $summaryMessage = implode(", \n", $this->summaryBuilder->build($response));

        return sprintf(
            '%s %s %s%s%s%s %s: %s',
            $checkIcon,
            __('weather-rules.success', $vars),
            self::NEW_LINE,
            $summaryMessage,
            self::NEW_LINE,
            $eyesEmoji,
            __('main.updated'),
            $updatedAt
        );
    }
}
