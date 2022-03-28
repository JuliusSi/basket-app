<?php

declare(strict_types=1);

namespace App\WeatherChecker\Manager;

use App\WeatherChecker\Collection\CheckerCollection;
use App\WeatherChecker\Collection\CheckerInterface;
use App\WeatherChecker\Collector\WarningCollector;
use App\WeatherChecker\Model\Warning;
use App\WeatherChecker\Service\WeatherService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use LogicException;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Class WeatherCheckManager.
 */
class WeatherCheckManager
{
    private WeatherService $weatherForBasketBallService;

    private CheckerCollection $checkerCollection;

    private WarningCollector $collector;

    /**
     * WeatherCheckManager constructor.
     */
    public function __construct(
        WeatherService $weatherForBasketBallService,
        CheckerCollection $checkerCollection,
        WarningCollector $collector
    ) {
        $this->weatherForBasketBallService = $weatherForBasketBallService;
        $this->checkerCollection = $checkerCollection;
        $this->collector = $collector;
    }

    /**
     * @throws Exception
     *
     * @return Warning[]
     */
    public function manage(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        if (empty($placeCode)) {
            throw new LogicException('Place code cannot be empty');
        }

        return $this->getCachedWarnings($placeCode, $startDateTime, $endDateTime);
    }

    /**
     * @throws Exception
     *
     * @return Warning[]
     */
    private function getCachedWarnings(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDateTime)->format('Y-m-d H');
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $endDateTime)->format('Y-m-d H');
        $key = sprintf('%s_%s_%s', $placeCode, $startDate, $endDate);

        return Cache::remember(
            $key,
            600,
            function () use ($placeCode, $startDate, $endDate) {
                return $this->getWarnings($placeCode, $startDate, $endDate);
            }
        );
    }

    /**
     * @throws Exception
     *
     * @return Warning[]
     */
    private function getWarnings(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        $this->collector->reset();
        foreach ($this->getFilteredForecasts($placeCode, $startDateTime, $endDateTime) as $forecastTimestamp) {
            $this->applyCheckers($forecastTimestamp);
        }

        return $this->collector->getWarnings();
    }

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
     * @throws Exception
     *
     * @return ForecastTimestamp[]
     */
    private function getFilteredForecasts(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        return $this->weatherForBasketBallService->getFilteredForecasts($placeCode, $startDateTime, $endDateTime);
    }
}
