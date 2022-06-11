<?php

declare(strict_types=1);

namespace App\WeatherChecker\Repository;

use App\WeatherChecker\Collector\Warning\WeatherWarningCollector;
use App\WeatherChecker\Filter\ForecastsByDateFilter;
use App\WeatherChecker\Model\Response\WarningResponse;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Response\ForecastTimestamp;
use Src\Weather\Client\Response\Response;
use Src\Weather\Repository\CachedWeatherRepository;

class WeatherWarningRepository
{
    public function __construct(
        private readonly Collection $collectorsCollection,
        private readonly CachedWeatherRepository $cachedWeatherRepository,
        private readonly ForecastsByDateFilter $forecastsByDateFilter,
    ) {
    }

    public function find(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): WarningResponse
    {
        $newStartDate = $this->getStartDate($startDate);

        return $this->collect($placeCode, $newStartDate, $endDate);
    }

    protected function getStartDate(CarbonInterface $startDateTime): CarbonInterface
    {
        return $startDateTime->subHours(3);
    }

    /**
     * @throws Exception
     */
    private function collect(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): WarningResponse
    {
        $response = $this->getWeatherInformation($placeCode);
        $forecasts = $this->forecastsByDateFilter->filter($response->getForecastTimestamps(), $startDate, $endDate);
        $warnings = $this->getWarnings($forecasts);

        return $this->buildResponse($response, $warnings);
    }

    /**
     * @throws Exception
     */
    private function getWarnings(array $forecasts): array
    {
        $warnings = [];

        foreach ($forecasts as $filteredForecast) {
            array_push($warnings, ...$this->applyCollectors($filteredForecast));
        }

        return $warnings;
    }

    /**
     * @param  string[]  $warnings
     */
    private function buildResponse(Response $response, array $warnings): WarningResponse
    {
        $warningsResponse = new WarningResponse();
        $warningsResponse->setMeasuredAt($response->getForecastCreationTimeUtc());
        $warningsResponse->setWarnings($this->buildWarnings($warnings));

        return $warningsResponse;
    }

    /**
     * @param  string[]  $warnings
     *
     * @return Warning[]
     */
    private function buildWarnings(array $warnings): array
    {
        array_walk($warnings, function (&$warning) {
            $warning = $this->buildWarning($warning);
        });

        return $warnings;
    }

    private function buildWarning(string $message): Warning
    {
        $warning = new Warning();
        $warning->setTranslatedMessage($message);

        return $warning;
    }

    /**
     * @return string[]
     *
     * @throws Exception
     */
    private function applyCollectors(ForecastTimestamp $forecast): array
    {
        $warnings = [];

        foreach ($this->getCollectors() as $collector) {
            if ($collector->supports($forecast)) {
                array_push($warnings, ...$collector->collect($forecast));
            }
        }

        return $warnings;
    }


    /**
     * @return WeatherWarningCollector[]
     */
    private function getCollectors(): array
    {
        return $this->collectorsCollection->all();
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
