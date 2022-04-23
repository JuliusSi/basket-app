<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collection;

abstract class AbstractChecker implements CheckerInterface
{
    protected function getKey(string $date, int $hour, string $rule): string
    {
        return $date.'_'.$hour.'_'.$rule;
    }
}
