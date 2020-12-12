<?php

namespace App\WeatherChecker\Collection;

/**
 * Class AbstractChecker
 * @package App\WeatherChecker\Collection
 */
abstract class AbstractChecker implements CheckerInterface
{
    /**
     * @param  int  $hour
     * @param  string  $rule
     * @return string
     */
    protected function getKey(int $hour, string $rule): string
    {
        return $hour . '_' . $rule;
    }
}
