<?php

declare(strict_types=1);

namespace App\WeatherChecker\Collector;

use App\WeatherChecker\Model\Warning;
use Exception;
use Src\Weather\Client\Response\ForecastTimestamp;

interface WeatherWarningCollectorInterface
{
    /**
     * @throws Exception
     *
     * @return Warning[]
     */
    public function collect(ForecastTimestamp $forecast): array;

    public function supports(ForecastTimestamp $forecast): bool;
}
