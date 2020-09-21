<?php

namespace App\Service;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Class WeatherForBasketBallWarningService
 * @package App\Service
 */
class WeatherForBasketBallWarningService
{
    /**
     * @var WeatherForBasketBallService
     */
    private WeatherForBasketBallService $weatherForBasketBallService;

    /**
     * WeatherForBasketBallWarningService constructor.
     * @param  WeatherForBasketBallService  $weatherForBasketBallService
     */
    public function __construct(WeatherForBasketBallService $weatherForBasketBallService)
    {
        $this->weatherForBasketBallService = $weatherForBasketBallService;
    }

    /**
     * @return string[]
     */
    public function getWarningMessages(): array
    {
        $messages = [];
        foreach ($this->getWeatherInformation() as $item) {
            if ($item->getTotalPrecipitation() > config('weather.max_precipitation')) {
                $messages['weather-rules.precipitation'] = __(
                    'weather-rules.precipitation',
                    ['precipitation' => $item->getTotalPrecipitation()]
                );
            }
            if ($item->getAirTemperature() > config('weather.max_air_temperature')) {
                $messages['to_high_air_temperature'] = __(
                    'weather-rules.to_high_air_temperature',
                    ['airTemperature' => $item->getAirTemperature()]
                );
            }
            if ($this->isToLowAirTemperature($item)) {
                $date = Carbon::parse($item->getForecastTimeUtc());
                $messages['to_low_air_temperature'] = __(
                    'weather-rules.to_low_air_temperature',
                    ['airTemperature' => $item->getAirTemperature(), 'time' => $date->hour]
                );
            }
            $this->logWeather($item);
        }

        return $messages;
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

    /**
     * @param  ForecastTimestamp  $weatherInformation
     */
    private function logWeather(ForecastTimestamp $weatherInformation): void
    {
        Log::info(sprintf('date: %s', $weatherInformation->getForecastTimeUtc()));
        Log::info(sprintf('precipitation: %s', $weatherInformation->getTotalPrecipitation()));
        Log::info(sprintf('air temperature: %s', $weatherInformation->getAirTemperature()));
        Log::info(sprintf('wind speed: %s', $weatherInformation->getWindSpeed()));
    }

    /**
     * @return ForecastTimestamp[]
     */
    private function getWeatherInformation(): array
    {
        return $this->weatherForBasketBallService->getFilteredWeatherInformation();
    }
}
