<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

class PrecipitationChecker extends AbstractChecker
{
    public const RULE_PRECIPITATION = 'precipitation';

    /**
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $warnings = [];

        $dateString = $date->format('m-d');
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
