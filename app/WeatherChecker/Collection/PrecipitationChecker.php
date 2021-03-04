<?php

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Class PrecipitationChecker
 * @package App\WeatherChecker\Collection
 */
class PrecipitationChecker extends AbstractChecker
{
    public const RULE_PRECIPITATION = 'precipitation';

    /**
     * @param  ForecastTimestamp  $weatherInfo
     * @param  CarbonInterface  $date
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $warnings = [];
        $dateString = $date->toDateString();
        if ($weatherInfo->getTotalPrecipitation() > config('weather.rules.max_precipitation')) {
            $key = $this->getKey($dateString, $date->hour, self::RULE_PRECIPITATION);
            $warnings[$key] = __(
                'weather-rules.precipitation',
                ['precipitation' => $weatherInfo->getTotalPrecipitation(), 'hour' => $date->hour, 'date' => $dateString]
            );
        }

        return $warnings;
    }
}
