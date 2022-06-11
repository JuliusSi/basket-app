<?php

declare(strict_types=1);

namespace App\WeatherChecker\Service;

use App\WeatherChecker\Filter\ForecastsByDateFilter;
use App\WeatherChecker\Model\Response\WeatherInformationResponse;
use Carbon\CarbonInterface;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
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
     * @throws Exception
     */
    public function get(
        string $placeCode,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): WeatherInformationResponse {
        $response = $this->getWeatherInformation($placeCode);
        $forecasts = $this->forecastsByDateFilter->filter($response->getForecastTimestamps(), $startDate, $endDate);

        return $this->buildResponse($forecasts, $response);
    }

    private function buildResponse(array $forecasts, Response $response): WeatherInformationResponse
    {
        $weatherInformation = new WeatherInformationResponse();
        $weatherInformation->setForecasts($forecasts);
        $weatherInformation->setMeasuredAt($response->getForecastCreationTimeUtc());

        return $weatherInformation;
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
