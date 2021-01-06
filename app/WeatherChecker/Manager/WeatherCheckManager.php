<?php

namespace App\WeatherChecker\Manager;

use App\WeatherChecker\Service\WeatherForBasketBallService;
use App\WeatherChecker\Collection\CheckerCollection;
use App\WeatherChecker\Collection\CheckerInterface;
use App\WeatherChecker\Collector\WarningCollector;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Class WeatherCheckManager
 * @package App\WeatherChecker\Manager
 */
class WeatherCheckManager
{
    /**
     * @var WeatherForBasketBallService
     */
    private WeatherForBasketBallService $weatherForBasketBallService;

    /**
     * @var CheckerCollection
     */
    private CheckerCollection $checkerCollection;

    /**
     * @var WarningCollector
     */
    private WarningCollector $collector;

    /**
     * WeatherCheckManager constructor.
     * @param  WeatherForBasketBallService  $weatherForBasketBallService
     * @param  CheckerCollection  $checkerCollection
     * @param  WarningCollector  $collector
     */
    public function __construct(
        WeatherForBasketBallService $weatherForBasketBallService,
        CheckerCollection $checkerCollection,
        WarningCollector $collector
    ) {
        $this->weatherForBasketBallService = $weatherForBasketBallService;
        $this->checkerCollection = $checkerCollection;
        $this->collector = $collector;
    }

    /**
     * @param  string|null  $placeCode
     * @param  string  $startDateTime
     * @param  string  $endDateTime
     * @return Warning[]
     */
    public function manage(?string $placeCode, string $startDateTime, string $endDateTime): array
    {
        if (!$placeCode) {
            return [];
        }

        return $this->getWarnings($placeCode, $startDateTime, $endDateTime);
    }

    /**
     * @param  string  $placeCode
     * @param  string  $startDateTime
     * @param  string  $endDateTime
     * @return Warning[]
     */
    private function getWarnings(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        foreach ($this->getFilteredForecasts($placeCode, $startDateTime, $endDateTime) as $forecastTimestamp) {
            $this->applyCheckers($forecastTimestamp);
        }

        return $this->collector->getWarnings();
    }

    /**
     * @param  ForecastTimestamp  $forecastTimestamp
     */
    private function applyCheckers(ForecastTimestamp $forecastTimestamp): void
    {
        foreach ($this->getCheckers() as $checker) {
            $date = Carbon::parse($forecastTimestamp->getForecastTimeUtc());
            $this->collector->addUniqueWarnings($checker->check($forecastTimestamp, $date));
        }
    }

    /**
     * @return CheckerInterface[]
     */
    private function getCheckers(): array
    {
        return $this->checkerCollection->getItems();
    }

    /**
     * @param  string  $placeCode
     * @param  string  $startDateTime
     * @param  string  $endDateTime
     * @return ForecastTimestamp[]
     */
    private function getFilteredForecasts(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        return $this->weatherForBasketBallService->getFilteredForecasts($placeCode, $startDateTime, $endDateTime);
    }
}
