<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

use App\WeatherChecker\Collector\Warning\Handler\WarningCollectHandler;
use App\WeatherChecker\Filter\ForecastsByDateFilter;
use App\WeatherChecker\Model\Response\Average;
use App\WeatherChecker\Model\Response\WeatherResponse;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Exception;
use Src\Weather\Client\Response\ForecastTimestamp;
use Src\Weather\Client\Response\Response;

class WeatherResponseBuilder
{
    public function __construct(
        private readonly WarningCollectHandler $collectHandler,
        private readonly ForecastsByDateFilter $forecastsByDateFilter,
        private readonly AverageWeatherBuilder $averageWeatherBuilder,
    ) {
    }

    /**
     * @throws Exception
     */
    public function build(Response $response, CarbonInterface $startDate, CarbonInterface $endDate): WeatherResponse
    {
        return $this->buildResponse($response, $startDate, $endDate);
    }

    /**
     * @throws Exception
     */
    private function buildResponse(
        Response $rawResponse,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): WeatherResponse {
        $response = new WeatherResponse();
        $response->setMeasuredAt($rawResponse->getForecastCreationTimeUtc());
        $response->setWarnings($this->getWarnings($rawResponse, $startDate, $endDate));
        $response->setCheckedFrom($startDate->toDateTime());
        $response->setCheckedTo($endDate->toDateTime());
        $response->setAverage($this->getAverage($rawResponse, $startDate, $endDate));

        return $response;
    }

    /**
     * @return Warning[]
     *
     * @throws Exception
     */
    private function getWarnings(
        Response $rawResponse,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): array {
        $startDateForFiltering = Carbon::instance($startDate)->subHours(3);
        $forecasts = $this->filterForecasts($rawResponse, $startDateForFiltering, $endDate);

        return $this->collectHandler->getWarnings($forecasts);
    }

    private function getAverage(
        Response $rawResponse,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): Average {
        $forecasts = $this->filterForecasts($rawResponse, $startDate, $endDate);

        return $this->averageWeatherBuilder->build($forecasts);
    }

    /**
     * @return ForecastTimestamp[]
     */
    private function filterForecasts(Response $response, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        return $this->forecastsByDateFilter->filter(
            $response->getForecastTimestamps(),
            $startDate,
            $endDate
        );
    }
}
