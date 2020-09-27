<?php

namespace App\WeatherChecker\Collector;

/**
 * Class WarningCollector
 * @package App\WeatherChecker\Collector
 */
class WarningCollector
{
    /**
     * @var string[]
     */
    private array $warnings = [];

    /**
     * @param  string[]  $warnings
     */
    public function addUniqueWarnings(array $warnings): void
    {
        foreach ($warnings as $key => $warning) {
            if (!isset($this->warnings[$key])) {
                $this->warnings[$key] = $warning;
            }
        }
    }

    /**
     * @return string[]
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * @param  string[]  $warnings
     */
    public function setWarnings(array $warnings): void
    {
        $this->warnings = $warnings;
    }
}
