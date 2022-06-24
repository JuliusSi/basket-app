<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

use App\WeatherChecker\Model\Response\WeatherResponse;

class WeatherSummaryBuilder
{
    public function build(WeatherResponse $response): array
    {
        if (!$average = $response->getAverage()) {
            return [];
        }

        $messages = [];

        if ($average->getAirTemperature()) {
            $thermometer = html_entity_decode('&#127777;');
            $message = __(
                'weather.average_air_temperature',
                ['airTemperature' => $average->getAirTemperature()]
            );
            $messages[] = $thermometer.' '.$message;
        }

        if ($average->getWindSpeed()) {
            $tornado = html_entity_decode('&#127786;');
            $message = __(
                'weather.average_wind_speed',
                ['windSpeed' => $average->getWindSpeed()]
            );

            $messages[] = $tornado.' '.$message;
        }

        if ($average->getTotalPrecipitation()) {
            $rain = html_entity_decode('&#127783;');
            $message = __(
                'weather.average_precipitation',
                ['precipitation' => $average->getTotalPrecipitation()]
            );

            $messages[] = $rain.' '.$message;
        }

        if ($average->getHumidity()) {
            $droplet = html_entity_decode('&#128167;');
            $message = __(
                'weather.average_humidity',
                ['humidity' => $average->getHumidity()]
            );

            $messages[] = $droplet.' '.$message;
        }

        return $messages;
    }
}
