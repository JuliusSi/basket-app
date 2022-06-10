<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Illuminate\Support\Arr;
use function in_array;
use Src\Weather\Client\Response\ForecastTimestamp;

class AirTemperatureChecker extends AbstractChecker
{
    public const RULE_TO_HIGH_AIR_TEMPERATURE = 'too_high_air_temperature';
    public const RULE_TO_LOW_AIR_TEMPERATURE = 'too_low_air_temperature';

    /**
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $warnings = [];
        $dateString = $date->toDateString();
        if ($this->isToHighAirTemperature($weatherInfo)) {
            $key = $this->getKey($dateString, $date->hour, self::RULE_TO_HIGH_AIR_TEMPERATURE);
            $warnings[$key] = __(
                'weather-rules.too_high_air_temperature',
                ['airTemperature' => $weatherInfo->getAirTemperature(), 'hour' => $date->hour, 'date' => $dateString]
            );
        }
        if ($this->isToLowAirTemperature($weatherInfo, $date)) {
            $key = $this->getKey($dateString, $date->hour, self::RULE_TO_LOW_AIR_TEMPERATURE);
            $warnings[$key] = __(
                'weather-rules.too_low_air_temperature',
                ['airTemperature' => $weatherInfo->getAirTemperature(), 'hour' => $date->hour, 'date' => $dateString]
            );
        }

        return $warnings;
    }

    private function isToLowAirTemperature(ForecastTimestamp $weatherInformation, CarbonInterface $date): bool
    {
        if ($this->isClear($weatherInformation)
            && $weatherInformation->getWindSpeed() <= config('weather.rules.slow_wind_speed')
            && $weatherInformation->getAirTemperature() >= config(
                'weather.rules.min_air_temperature_if_clear_if_slow_wind'
            )) {
            return false;
        }

        if ($this->isClear($weatherInformation)
            && $weatherInformation->getAirTemperature() >= config('weather.rules.min_air_temperature_if_clear')) {
            return false;
        }

        if ($date->isSaturday()
            && $weatherInformation->getAirTemperature() >= config(
                'weather.rules.min_air_temperature_if_clear_if_slow_wind'
            )) {
            return false;
        }

        if ($weatherInformation->getAirTemperature() >= config('weather.rules.min_air_temperature')) {
            return false;
        }

        return true;
    }

    private function isToHighAirTemperature(ForecastTimestamp $weatherInformation): bool
    {
        if ($weatherInformation->getAirTemperature() > config('weather.rules.max_air_temperature')) {
            return true;
        }

        if ($this->isClear($weatherInformation)
            && $weatherInformation->getWindSpeed() <= config('weather.rules.slow_wind_speed')
            && $weatherInformation->getAirTemperature() >= config(
                'weather.rules.max_air_temperature_if_clear_if_slow_wind'
            )) {
            return true;
        }

        return false;
    }

    private function isClear(ForecastTimestamp $weatherInformation): bool
    {
        return in_array(
            $weatherInformation->getConditionCode(),
            [
                ForecastTimestamp::CONDITION_CODE_CLEAR,
                ForecastTimestamp::CONDITION_CODE_ISOLATED_CLOUDS,
            ],
            true
        );
    }
}
