<?php

declare(strict_types=1);

namespace App\WeatherChecker\Repository;

use App\WeatherChecker\Builder\WeatherResponseBuilder;
use App\WeatherChecker\Model\Response\WeatherResponse;
use Carbon\CarbonInterface;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Response\Response;
use Src\Weather\Repository\CachedWeatherForecastsRepository;

class WeatherRepository
{
    public function __construct(
        private readonly CachedWeatherForecastsRepository $forecastsRepository,
        private readonly WeatherResponseBuilder $builder
    ) {
    }

    /**
     * @throws Exception
     */
    public function find(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): WeatherResponse
    {
        return $this->getResponse($placeCode, $startDate, $endDate);
    }

    /**
     * @throws Exception
     */
    private function getResponse(
        string $placeCode,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): WeatherResponse {
        $rawResponse = $this->getWeatherInformation($placeCode);

        return $this->builder->build($rawResponse, $startDate, $endDate);
    }

    /**
     * @throws Exception
     */
    private function getWeatherInformation(string $placeCode): Response
    {
        try {
            return $this->forecastsRepository->find($placeCode);
        } catch (GuzzleException $exception) {
            Log::warning(sprintf('Can not get response from weather provider. %s', $exception->getMessage()));

            throw new Exception(__('weather.exception'));
        }
    }
}
