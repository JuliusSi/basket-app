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
    /**
     * @param  ForecastTimestamp  $weatherInfo
     * @param  CarbonInterface  $date
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array
    {
        $messages = [];
        if ($weatherInfo->getTotalPrecipitation() > config('weather.rules.max_precipitation')) {
            $messages['precipitation'] = __(
                'weather-rules.precipitation',
                ['precipitation' => $weatherInfo->getTotalPrecipitation(), 'hour' => $date->hour]
            );
        }

        return $messages;
    }
}
