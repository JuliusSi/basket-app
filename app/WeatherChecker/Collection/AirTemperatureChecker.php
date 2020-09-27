<?php

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Class AirTemperatureChecker
 * @package App\WeatherChecker\Collection
 */
class AirTemperatureChecker implements CheckerInterface
{
    /**
     * @param  ForecastTimestamp  $weatherInfo
     * @param  CarbonInterface  $date
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $warnings = [];
        if ($weatherInfo->getAirTemperature() > config('weather.max_air_temperature')) {
            $warnings['too_high_air_temperature'] = __(
                'weather-rules.too_high_air_temperature',
                ['airTemperature' => $weatherInfo->getAirTemperature(), 'hour' => $date->hour]
            );
        }
        if ($this->isToLowAirTemperature($weatherInfo)) {
            $warnings['too_low_air_temperature'] = __(
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
            $weatherInformation->getAirTemperature() >= config('weather.min_air_temperature_if_clear')) {
            return false;
        }
        if ($weatherInformation->getAirTemperature() >= config('weather.min_air_temperature')) {
            return false;
        }

        return true;
    }
}
