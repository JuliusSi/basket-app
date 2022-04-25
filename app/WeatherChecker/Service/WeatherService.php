<?php

declare(strict_types=1);

namespace App\WeatherChecker\Service;

use Carbon\CarbonInterface;
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
     * @return ForecastTimestamp[]
     *
     * @throws Exception
     *
     */
    public function getFilteredForecasts(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        $response = $this->getWeatherInformation($placeCode);

        return $this->filterWeatherInformation($response, $startDate, $endDate);
    }

    /**
     * @return ForecastTimestamp[]
     */
    private function filterWeatherInformation(
        Response $response,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): array {
        $filteredForecasts = [];

        foreach ($response->getForecastTimestamps() as $forecastTimestamp) {
            if ($this->isValidForecastTimeStamp($forecastTimestamp, $startDate, $endDate)) {
                $filteredForecasts[] = $forecastTimestamp;
            }
        }

        usort($filteredForecasts, static fn($a, $b) => $a->getForecastTimeUtc() <=> $b->getForecastTimeUtc());

        return $filteredForecasts;
    }

    private function isValidForecastTimeStamp(
        ForecastTimestamp $forecastTimeStamp,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): bool {
        $forecastDate = $forecastTimeStamp->getForecastDate()->format('Y-m-d H');
        $startDateFormatted = $startDate->format('Y-m-d H');
        $endDateFormatted = $endDate->format('Y-m-d H');

        return $endDateFormatted >= $forecastDate
            && $forecastDate >= $startDateFormatted;
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
