<?php

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Class ConditionCodeChecker
 * @package App\WeatherChecker\Collection
 */
class ConditionCodeChecker extends AbstractChecker
{
    public const RULE_HEAVY_SNOW = 'heavy_snow';

    /**
     * @param  ForecastTimestamp  $weatherInfo
     * @param  CarbonInterface  $date
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $messages = [];
        if ($weatherInfo->getConditionCode() === ForecastTimestamp::CONDITION_CODE_HEAVY_SNOW) {
            $key = $this->getKey($date->hour, self::RULE_HEAVY_SNOW);
            $messages[$key] = __(
                'weather-rules.heavy_snow',
                ['hour' => $date->hour]
            );
        }

        return $messages;
    }
}
