<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

class PastPrecipitationChecker extends AbstractChecker
{
    private const RULE_PRECIPITATION = 'past_precipitation';

    /**
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        return $this->getPrecipitationWarnings($weatherInfo, $date);
    }

    private function getPrecipitationWarnings(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $warnings = [];

        $dateString = $date->format('m-d');
        if ($weatherInfo->getTotalPrecipitation() > config('weather.rules.max_past_precipitation')) {
            $key = $this->getKey($dateString, $date->hour, self::RULE_PRECIPITATION);
            $warnings[$key] = __(
                'weather-rules.past_precipitation',
                ['precipitation' => $weatherInfo->getTotalPrecipitation(), 'hour' => $date->hour, 'date' => $dateString]
            );
        }

        return $warnings;
    }
}
