<?php

declare(strict_types=1);

namespace App\WeatherChecker\Filter;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

class ForecastsByDateFilter
{
    /**
     * @return ForecastTimestamp[]
     */
    public function filter(
        array $forecasts,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): array {
        $filteredForecasts = [];

        foreach ($forecasts as $forecastTimestamp) {
            if ($this->isValidForecastTimeStamp($forecastTimestamp, $startDate, $endDate)) {
                $filteredForecasts[] = $forecastTimestamp;
            }
        }

        usort($filteredForecasts, static fn ($a, $b) => $a->getForecastTimeUtc() <=> $b->getForecastTimeUtc());

        return $filteredForecasts;
    }

    private function isValidForecastTimeStamp(
        ForecastTimestamp $forecastTimeStamp,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): bool {
        $forecastDate = $forecastTimeStamp->getForecastDate()->format('Y-m-d H');
        $startDateFormatted = $startDate->format('Y-m-d H');
        $endDateFormatted = $endDate->format('Y-m-d H');

        return $endDateFormatted >= $forecastDate
            && $forecastDate >= $startDateFormatted;
    }
}
