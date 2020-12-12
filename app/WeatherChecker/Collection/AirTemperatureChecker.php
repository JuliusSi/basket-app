<?php

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Class AirTemperatureChecker
 * @package App\WeatherChecker\Collection
 */
class AirTemperatureChecker extends AbstractChecker
{
    public const RULE_TO_HIGH_AIR_TEMPERATURE = 'too_high_air_temperature';
    public const RULE_TO_LOW_AIR_TEMPERATURE = 'too_low_air_temperature';

    /**
     * @param  ForecastTimestamp  $weatherInfo
     * @param  CarbonInterface  $date
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $warnings = [];
        if ($weatherInfo->getAirTemperature() > config('weather.rules.max_air_temperature')) {
            $key = $this->getKey($date->hour, self::RULE_TO_HIGH_AIR_TEMPERATURE);
            $warnings[$key] = __(
                'weather-rules.too_high_air_temperature',
                ['airTemperature' => $weatherInfo->getAirTemperature(), 'hour' => $date->hour]
            );
        }
        if ($this->isToLowAirTemperature($weatherInfo)) {
            $key = $this->getKey($date->hour, self::RULE_TO_LOW_AIR_TEMPERATURE);
            $warnings[$key] = __(
                'weather-rules.too_low_air_temperature',
                ['airTemperature' => $weatherInfo->getAirTemperature(), 'hour' => $date->hour]
            );
        }

        return $warnings;
    }

    /**
     * @param  ForecastTimestamp  $weatherInformation
     * @return bool
     */
    private function isToLowAirTemperature(ForecastTimestamp $weatherInformation): bool
    {
        if ($weatherInformation->getConditionCode() === ForecastTimestamp::CONDITION_CODE_CLEAR &&
            $weatherInformation->getAirTemperature() >= config('weather.rules.min_air_temperature_if_clear')) {
            return false;
        }
        if ($weatherInformation->getAirTemperature() >= config('weather.rules.min_air_temperature')) {
            return false;
        }

        return true;
    }
}
