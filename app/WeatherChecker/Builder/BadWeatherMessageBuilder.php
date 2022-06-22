<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

use App\WeatherChecker\Model\Response\WarningResponse;
use App\WeatherChecker\Model\Warning;

class BadWeatherMessageBuilder
{
    private const NEW_LINE = "\n";

    public function getMessage(WarningResponse $response): string
    {
        return $this->getBadWeatherMessage($response);
    }

    public function getFacebookMessage(WarningResponse $response): string
    {
        $warnings = $this->getTranslatedMessages($response->getWarnings());
        $warningIcon = html_entity_decode('&#9888;');
        $warningsWithEmojis = substr_replace($warnings, $warningIcon.' ', 0, 0);
        $warningsMessage = implode(", \n", $warningsWithEmojis);
        $crossMarkEmoji = html_entity_decode('&#10062;');
        $eyesEmoji = html_entity_decode('&#128064;');

        return sprintf(
            '%s %s:%s%s.%s%s %s: %s',
            $crossMarkEmoji,
            __('weather-rules.error', ['hours' => config('weather.rules.hours_to_check')]),
            self::NEW_LINE,
            $warningsMessage,
            self::NEW_LINE,
            $eyesEmoji,
            __('main.updated'),
            $response->getMeasuredAt()->format('H:i'),
        );
    }

    private function getBadWeatherMessage(WarningResponse $response): string
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
