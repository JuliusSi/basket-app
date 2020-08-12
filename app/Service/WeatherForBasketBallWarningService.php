<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Class WeatherForBasketBallWarningService
 * @package App\Service
 */
class WeatherForBasketBallWarningService
{
    private const MAX_PRECIPITATION = 0;
    private const MAX_AIR_TEMPERATURE = 26;
    private const MIN_AIR_TEMPERATURE = 15;

    /**
     * @var WeatherForBasketBallService
     */
    private WeatherForBasketBallService $weatherForBasketBallService;

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
        foreach ($this->getWeatherInformation() as $weatherInformation) {
            if ($weatherInformation->getTotalPrecipitation() > self::MAX_PRECIPITATION) {
                $messages['weather-rules.precipitation'] = __('weather-rules.precipitation');
            }
            if ($weatherInformation->getAirTemperature() > self::MAX_AIR_TEMPERATURE) {
                $messages['to_high_air_temperature'] = __('weather-rules.to_high_air_temperature');
            }
            if ($weatherInformation->getAirTemperature() < self::MIN_AIR_TEMPERATURE) {
                $messages['to_low_air_temperature'] = __('weather-rules.to_low_air_temperature');
            }
            $this->logWeather($weatherInformation);
        }

        return $messages;
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
