<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

class HumidityChecker extends AbstractChecker
{
    private const RULE_TO_HIGH_HUMIDITY = 'too_high_air_humidity';

    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $dateString = $date->format('m-d');
        $warnings = [];

        if ($this->isToHighHumidity($weatherInfo)) {
            $key = $this->getKey($dateString, $date->hour, self::RULE_TO_HIGH_HUMIDITY);
            $warnings[$key] = __(
                'weather-rules.too_high_air_humidity',
                ['humidity' => $weatherInfo->getHumidity(), 'hour' => $date->hour, 'date' => $dateString]
            );
        }

        return $warnings;
    }

    private function isToHighHumidity(ForecastTimestamp $weatherInfo): bool
    {
        if ($weatherInfo->getTotalPrecipitation() > config('weather.rules.max_precipitation')) {
            return false;
        }

        if ($weatherInfo->getAirTemperature() < config('weather.rules.min_air_temperature_to_check_humidity')) {
            return false;
        }

        return $weatherInfo->getHumidity() > config('weather.rules.max_humidity');
    }
}
