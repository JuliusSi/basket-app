<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

class ConditionCodeChecker extends AbstractChecker
{
    public const RULE_HEAVY_SNOW = 'heavy_snow';

    /**
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $warnings = [];
        $dateString = $date->toDateString();
        if (ForecastTimestamp::CONDITION_CODE_HEAVY_SNOW === $weatherInfo->getConditionCode()) {
            $key = $this->getKey($dateString, $date->hour, self::RULE_HEAVY_SNOW);
            $warnings[$key] = __(
                'weather-rules.heavy_snow',
                ['hour' => $date->hour, 'date' => $dateString]
            );
        }

        return $warnings;
    }
}
