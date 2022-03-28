<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collection;

use Carbon\CarbonInterface;
use Src\Weather\Client\Response\ForecastTimestamp;

/**
 * Interface CheckerInterface.
 */
interface CheckerInterface
{
    /**
     * @return string[]
     */
    public function check(ForecastTimestamp $weatherInfo, CarbonInterface $date): array;
}
