<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

use App\WeatherChecker\Model\Response\WeatherResponse;
use App\WeatherChecker\Model\Warning;

class BadWeatherMessageBuilder
{
    private const NEW_LINE = "\n";

    public function __construct(private readonly WeatherSummaryBuilder $summaryBuilder)
    {
    }

    public function getMessage(WeatherResponse $response): string
    {
        return $this->getBadWeatherMessage($response);
    }

    public function getFacebookMessage(WeatherResponse $response): string
    {
        $warnings = $this->getTranslatedMessages($response->getWarnings());
        $warningIcon = html_entity_decode('&#9888;');
        $warningsWithEmojis = substr_replace($warnings, $warningIcon.' ', 0, 0);
        $warningsMessage = implode(", \n", $warningsWithEmojis);
        $summaryMessage = implode(", \n", $this->summaryBuilder->build($response));
        $crossMarkEmoji = html_entity_decode('&#10060;');
        $eyesEmoji = html_entity_decode('&#128064;');

        return sprintf(
            '%s %s:%s%s.%s%s%s%s %s: %s',
            $crossMarkEmoji,
            __('weather-rules.error', ['hours' => config('weather.rules.hours_to_check')]),
            self::NEW_LINE,
            $warningsMessage,
            self::NEW_LINE,
            $summaryMessage,
            self::NEW_LINE,
            $eyesEmoji,
            __('main.updated'),
            $response->getMeasuredAt()->format('H:i'),
        );
    }

    private function getBadWeatherMessage(WeatherResponse $response): string
    {
        $warningsMessage = implode(', ', $this->getTranslatedMessages($response->getWarnings()));

        return sprintf(
            '%s: %s, %s: %s',
            __('weather-rules.error', ['hours' => config('weather.rules.hours_to_check')]),
            $warningsMessage,
            __('main.updated'),
            $response->getMeasuredAt()->format('H:i'),
        );
    }

    /**
     * @param Warning[] $warnings
     *
     * @return string[]
     */
    private function getTranslatedMessages(array $warnings): array
    {
        $translatedMessages = [];
        foreach ($warnings as $warning) {
            $translatedMessages[] = $warning->getTranslatedMessage();
        }

        return $translatedMessages;
    }
}
