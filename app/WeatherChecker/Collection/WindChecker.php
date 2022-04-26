<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

class WindChecker extends AbstractChecker
{
    public const RULE_TO_HIGH_WIND_SPEED = 'too_high_wind_speed';
    public const RULE_TO_HIGH_WIND_GUST = 'too_high_wind_gust';

    /**
     * @param  ForecastTimestamp  $weatherInfo
     * @param  CarbonInterface  $date
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $warnings = [];
        $dateString = $date->toDateString();
        if ($weatherInfo->getWindSpeed() > config('weather.rules.max_wind_speed')) {
            $key = $this->getKey($dateString, $date->hour, self::RULE_TO_HIGH_WIND_SPEED);
            $warnings[$key] = __(
                'weather-rules.too_high_wind_speed',
                ['windSpeed' => $weatherInfo->getWindSpeed(), 'hour' => $date->hour, 'date' => $dateString]
            );
        }
        if ($weatherInfo->getWindGust() > config('weather.rules.max_wind_gust')) {
            $key = $this->getKey($dateString, $date->hour, self::RULE_TO_HIGH_WIND_GUST);
            $warnings[$key] = __(
                'weather-rules.too_high_wind_gust',
                ['windGust' => $weatherInfo->getWindGust(), 'hour' => $date->hour, 'date' => $dateString]
            );
        }

        return $warnings;
    }
}
