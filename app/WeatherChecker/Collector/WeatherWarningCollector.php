<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collector;

use Illuminate\Support\Collection;
use App\WeatherChecker\Collection\CheckerInterface;
use App\WeatherChecker\Model\Warning;
use Carbon\CarbonInterface;
use Exception;
use Src\Weather\Client\Response\ForecastTimestamp;

class WeatherWarningCollector implements WeatherWarningCollectorInterface
{
    public function __construct(private readonly Collection $checkerCollection)
    {
    }

    /**
     * @return Warning[]
     *
     * @throws Exception
     */
    public function collect(ForecastTimestamp $forecast): array
    {
        return $this->applyCheckers($forecast, $forecast->getForecastDate());
    }

    private function applyCheckers(ForecastTimestamp $forecastTimestamp, CarbonInterface $forecastDate): array
    {
        $warnings = [];

        foreach ($this->getCheckers() as $checker) {
            $collectedWarnings = $checker->check($forecastTimestamp, $forecastDate);
            array_push($warnings, ...array_values($collectedWarnings));
        }

        return $warnings;
    }

    /**
     * @return CheckerInterface[]
     */
    private function getCheckers(): array
    {
        return $this->checkerCollection->all();
    }

    public function supports(ForecastTimestamp $forecast): bool
    {
        $forecastDate = $forecast->getForecastDate();

        if ($forecastDate->isPast()) {
            return false;
        }

        return true;
    }
}
