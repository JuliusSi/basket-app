<?php

declare(strict_types=1);

namespace App\WeatherChecker\Service;

use App\WeatherChecker\Filter\ForecastsByDateFilter;
use Carbon\CarbonInterface;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Response\ForecastTimestamp;
use Src\Weather\Client\Response\Response;
use Src\Weather\Repository\CachedWeatherRepository;

class WeatherService
{
    public function __construct(
        private readonly CachedWeatherRepository $cachedWeatherRepository,
        private readonly ForecastsByDateFilter $forecastsByDateFilter,
    ) {
    }

    /**
     * @return ForecastTimestamp[]
     *
     * @throws Exception
     */
    public function getFilteredForecasts(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        $response = $this->getWeatherInformation($placeCode);

        return $this->forecastsByDateFilter->filter($response->getForecastTimestamps(), $startDate, $endDate);
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
