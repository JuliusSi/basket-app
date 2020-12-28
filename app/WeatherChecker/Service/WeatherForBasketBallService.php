<?php

namespace App\WeatherChecker\Service;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Response\ForecastTimestamp;
use Src\Weather\Client\Response\Response;
use Src\Weather\Repository\CachedWeatherRepository;
use Illuminate\Support\Carbon;

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
     * @param  string  $placeCode
     * @return ForecastTimestamp[]
     */
    public function getFilteredWeatherInformation(string $placeCode): array
    {
        $response = $this->getWeatherInformation($placeCode);
        if (!$response) {
            return [];
        }

        return $this->filterWeatherInformation($response);
    }

    /**
     * @param  Response  $response
     * @return ForecastTimestamp[]
     */
    private function filterWeatherInformation(Response $response): array
    {
        $dateToCheck = $this->getDateTimeToCheck();
        $datetime = Carbon::now()->toDateTimeString();

        $weatherInformationArray = [];
        foreach ($response->getForecastTimestamps() as $forecastTimestamp) {
            if ($this->isValidForecastTimeStamp($forecastTimestamp, $dateToCheck, $datetime)) {
                $weatherInformationArray[] = $forecastTimestamp;
                if (count($weatherInformationArray) === config('weather.rules.hours_to_check')) {
                    return $weatherInformationArray;
                }
            }
        }

        return $weatherInformationArray;
    }

    /**
     * @return string
     */
    private function getDateTimeToCheck(): string
    {
        return Carbon::now()->addHours(config('weather.rules.hours_to_check'))->toDateTimeString();
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
     * @return Response|null
     */
    private function getWeatherInformation(string $placeCode): ?Response
    {
        try {
            return $this->cachedWeatherRepository->find($placeCode);
        } catch (GuzzleException $exception) {
            Log::warning(sprintf('Can not get response from meteo. %s', $exception->getMessage()));

            return null;
        }
    }
}
