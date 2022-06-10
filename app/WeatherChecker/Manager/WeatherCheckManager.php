<?php

declare(strict_types=1);

namespace App\WeatherChecker\Manager;

use App\WeatherChecker\Collector\Warning\WeatherWarningCollector;
use App\WeatherChecker\Model\Warning;
use App\WeatherChecker\Service\WeatherService;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
use Src\Weather\Client\Response\ForecastTimestamp;

class WeatherCheckManager
{
    private const CACHE_LIFE_TIME = 600;

    public function __construct(
        private readonly WeatherService $weatherForBasketBallService,
        private readonly Collection $collectorsCollection
    ) {
    }

    /**
     * @return Warning[]
     *
     * @throws Exception
     */
    public function manage(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        if (empty($placeCode)) {
            throw new InvalidArgumentException('Place code cannot be empty');
        }

        return $this->getCachedWarnings($placeCode, $startDateTime, $endDateTime);
    }

    /**
     * @return Warning[]
     *
     * @throws Exception
     */
    private function getCachedWarnings(string $placeCode, string $startDateTime, string $endDateTime): array
    {
        $startDate = $this->getStartDate($startDateTime);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $endDateTime);
        $key = sprintf('%s_%s_%s', $placeCode, $startDate->format('Y-m-d H'), $endDate->format('Y-m-d H'));

        return Cache::remember(
            $key,
            self::CACHE_LIFE_TIME,
            function () use ($placeCode, $startDate, $endDate) {
                return $this->getWarnings($placeCode, $startDate, $endDate);
            }
        );
    }

    private function getStartDate(string $startDateTime): CarbonInterface
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $startDateTime)->subHours(3);
    }

    /**
     * @return Warning[]
     *
     * @throws Exception
     *
     */
    private function getWarnings(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): array
    {
        $warnings = [];

        foreach ($this->getFilteredForecasts($placeCode, $startDate, $endDate) as $filteredForecast) {
            array_push($warnings, ...$this->applyCollectors($filteredForecast));
        }

        return $this->buildWarnings($warnings);
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
     * @return ForecastTimestamp[]
     * @throws Exception
     *
     */
    private function getFilteredForecasts(
        string $placeCode,
        CarbonInterface $startDate,
        CarbonInterface $endDate
    ): array {
        return $this->weatherForBasketBallService->getFilteredForecasts($placeCode, $startDate, $endDate);
    }
}
