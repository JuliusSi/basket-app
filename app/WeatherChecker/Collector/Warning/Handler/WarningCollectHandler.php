<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collector\Warning\Handler;

use App\WeatherChecker\Collector\Warning\WeatherWarningCollector;
use App\WeatherChecker\Model\Warning;
use Exception;
use Illuminate\Support\Collection;
use Src\Weather\Client\Response\ForecastTimestamp;

class WarningCollectHandler
{
    public function __construct(private readonly Collection $collectorsCollection)
    {
    }

    /**
     * @return Warning[]
     *
     * @throws Exception
     */
    public function getWarnings(array $forecasts): array
    {
        $warnings = [];

        foreach ($forecasts as $filteredForecast) {
            array_push($warnings, ...$this->applyCollectors($filteredForecast));
        }

        return $this->buildWarnings($warnings);
    }

    /**
     * @param string[] $warnings
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
     * @throws Exception
     *
     * @return string[]
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
}
