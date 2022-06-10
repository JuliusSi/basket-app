<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collection;

use App\WeatherChecker\Model\Warning;

abstract class AbstractChecker implements CheckerInterface
{
    protected function getKey(string $date, int $hour, string $rule): string
    {
        return $date.'_'.$hour.'_'.$rule;
    }

    /**
     * @param string[] $warnings
     *
     * @return Warning[]
     */
    protected function buildWarnings(array $warnings): array
    {
        array_walk($warnings, function (&$warning) {
            $warning = $this->buildWarning($warning);
        });

        return $warnings;
    }

    protected function buildWarning(string $message): Warning
    {
        $warning = new Warning();
        $warning->setUpdatedAt($message);

        return $warning;
    }
}
