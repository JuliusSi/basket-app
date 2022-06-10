<?php

declare(strict_types=1);

namespace App\WeatherChecker\Manager;

use App\WeatherChecker\Model\Response\WarningResponse;
use App\WeatherChecker\Service\WeatherWarningsService;
use Exception;
use InvalidArgumentException;

class WeatherCheckManager
{
    public function __construct(private readonly WeatherWarningsService $warningsService,) {
    }

    /**
     * @throws Exception
     */
    public function manage(string $placeCode, string $startDateTime, string $endDateTime): WarningResponse
    {
        if (empty($placeCode)) {
            throw new InvalidArgumentException('Place code cannot be empty');
        }

        return $this->warningsService->get($placeCode, $startDateTime, $endDateTime);
    }
}
