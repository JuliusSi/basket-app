<?php

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Class WindChecker
 * @package App\WeatherChecker\Collection
 */
class WindChecker implements CheckerInterface
{
    /**
     * @param  ForecastTimestamp  $weatherInfo
     * @param  CarbonInterface  $date
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $messages = [];
        if ($weatherInfo->getWindSpeed() > config('weather.max_wind_speed')) {
            $messages['too_high_wind_speed'] = __(
                'weather-rules.too_high_wind_speed',
                ['windSpeed' => $weatherInfo->getWindSpeed(), 'hour' => $date->hour]
            );
        }

        return $messages;
    }
}
