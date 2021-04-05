<?php

namespace App\WeatherChecker\Collector;

use App\WeatherChecker\Model\Warning;

/**
 * Class WarningCollector
 * @package App\WeatherChecker\Collector
 */
class WarningCollector
{
    /**
     * @var Warning[]
     */
    private array $warnings = [];

    /**
     * @param  string[]  $warnings
     */
    public function addUniqueWarnings(array $warnings): void
    {
        foreach ($warnings as $key => $warning) {
            if (!isset($this->warnings[$key])) {
                $this->warnings[$key] = $this->buildWarning($warning);
            }
        }
    }

    /**
     * @param  string  $message
     * @return Warning
     */
    private function buildWarning(string $message): Warning
    {
        $warning = new Warning();
        $warning->setTranslatedMessage($message);

        return $warning;
    }

    /**
     * @return Warning[]
     */
    public function getSortedWarnings(): array
    {
        $warnings = $this->warnings;
        ksort($warnings);

        return $warnings;
    }

    /**
     * @return Warning[]
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * @param  Warning[]  $warnings
     */
    public function setWarnings(array $warnings): void
    {
        $this->warnings = $warnings;
    }
}
