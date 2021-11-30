<?php

namespace App\WeatherChecker\Service;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Response\ForecastTimestamp;
use Src\Weather\Client\Response\Response;
use Src\Weather\Repository\CachedWeatherRepository;

/**
 * Class WeatherForBasketBallService
 * @package App\WeatherChecker\Service
 */
class WeatherForBasketBallService
{
    /**
     * @var CachedWeatherRepository
     */
    private CachedWeatherRepository $cachedWeatherRepository;

    /**
     * WeatherForBasketBallService constructor.
     * @param  CachedWeatherRepository  $cachedWeatherRepository
     */
    public function __construct(CachedWeatherRepository $cachedWeatherRepository)
    {
        $this->cachedWeatherRepository = $cachedWeatherRepository;
    }

    /**
     * @return ForecastTimestamp[]
     *
     * @throws Exception
     */
    public function getFilteredForecasts(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        $response = $this->getWeatherInformation($placeCode);

        return $this->filterWeatherInformation($response, $startDateTime, $endDateTime);
    }

    /**
     * @param  Response  $response
     * @param  string  $startDateTime
     * @param  string  $endDateTime
     * @return ForecastTimestamp[]
     */
    private function filterWeatherInformation(Response $response, string $startDateTime, string $endDateTime): array
    {
        $filteredForecasts = [];
        foreach ($response->getForecastTimestamps() as $forecastTimestamp) {
            if ($this->isValidForecastTimeStamp($forecastTimestamp, $endDateTime, $startDateTime)) {
                $filteredForecasts[] = $forecastTimestamp;
            }
        }

        return $filteredForecasts;
    }

    /**
     * @param  ForecastTimestamp  $forecastTimeStamp
     * @param  string  $datetimeAfterForHours
     * @param  string  $dateTime
     * @return bool
     */
    private function isValidForecastTimeStamp(
        ForecastTimestamp $forecastTimeStamp,
        string $datetimeAfterForHours,
        string $dateTime
    ): bool {
        $forecastTimestampUtc = $forecastTimeStamp->getForecastTimeUtc();

        return $datetimeAfterForHours > $forecastTimestampUtc &&
            $forecastTimestampUtc > $dateTime;
    }

    /**
     * @param  string  $placeCode
     * @return Response
     * @throws Exception
     */
    private function getWeatherInformation(string $placeCode): Response
    {
        try {
            return $this->cachedWeatherRepository->find($placeCode);
        } catch (GuzzleException $exception) {
            Log::warning(sprintf('Can not get response from meteo. %s', $exception->getMessage()));

            throw new Exception(__('weather.exception'));
        }
    }
}
