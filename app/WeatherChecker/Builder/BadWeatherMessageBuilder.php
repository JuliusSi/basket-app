<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

use App\WeatherChecker\Model\Response\WarningResponse;
use App\WeatherChecker\Model\Warning;

class BadWeatherMessageBuilder
{
    public function getMessage(WarningResponse $response): string
    {
        return $this->getBadWeatherMessage($response);
    }

    private function getBadWeatherMessage(WarningResponse $response): string
    {
        $warningsMessage = implode(', ', $this->getTranslatedMessages($response->getWarnings()));

        return sprintf(
            '%s: %s, %s: %s',
            __('weather-rules.error'),
            $warningsMessage,
            __('main.updated'),
            $response->getMeasuredAt(),
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
