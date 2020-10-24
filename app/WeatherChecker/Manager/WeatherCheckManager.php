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
     * @return Warning[]
     */
    public function manage(): array
    {
        foreach ($this->getWeatherInformation() as $item) {
            $this->applyCheckers($item);
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
     * @return ForecastTimestamp[]
     */
    private function getWeatherInformation(): array
    {
        return $this->weatherForBasketBallService->getFilteredWeatherInformation();
    }
}
