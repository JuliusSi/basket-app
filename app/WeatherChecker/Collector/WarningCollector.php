<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collector;

use App\WeatherChecker\Model\Warning;

class WarningCollector
{
    /**
     * @var Warning[]
     */
    private array $warnings = [];

    public function reset(): void
    {
        $this->warnings = [];
    }

    /**
     * @param string[] $warnings
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
     * @return Warning[]
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * @param Warning[] $warnings
     */
    public function setWarnings(array $warnings): void
    {
        $this->warnings = $warnings;
    }

    private function buildWarning(string $message): Warning
    {
        $warning = new Warning();
        $warning->setTranslatedMessage($message);

        return $warning;
    }
}
