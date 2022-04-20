<?php

declare(strict_types=1);

namespace App\WeatherChecker\Service;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Response\ForecastTimestamp;
use Src\Weather\Client\Response\Response;
use Src\Weather\Repository\CachedWeatherRepository;

class WeatherService
{
    public function __construct(private readonly CachedWeatherRepository $cachedWeatherRepository)
    {
    }

    /**
     * @throws Exception
     *
     * @return ForecastTimestamp[]
     */
    public function getFilteredForecasts(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        $response = $this->getWeatherInformation($placeCode);

        return $this->filterWeatherInformation($response, $startDateTime, $endDateTime);
    }

    /**
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

        usort($filteredForecasts, static fn ($a, $b) => $a->getForecastTimeUtc() <=> $b->getForecastTimeUtc());

        return $filteredForecasts;
    }

    private function isValidForecastTimeStamp(
        ForecastTimestamp $forecastTimeStamp,
        string $datetimeAfterForHours,
        string $dateTime
    ): bool {
        $forecastTimestampUtc = $forecastTimeStamp->getForecastTimeUtc();

        return $datetimeAfterForHours > $forecastTimestampUtc
            && $forecastTimestampUtc > $dateTime;
    }

    /**
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
