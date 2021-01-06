<?php

namespace App\WeatherChecker\Collection;

/**
 * Class AbstractChecker
 * @package App\WeatherChecker\Collection
 */
abstract class AbstractChecker implements CheckerInterface
{
    /**
     * @param  string  $date
     * @param  int  $hour
     * @param  string  $rule
     * @return string
     */
    protected function getKey(string $date, int $hour, string $rule): string
    {
        return $date . '_' . $hour . '_' . $rule;
    }
}
