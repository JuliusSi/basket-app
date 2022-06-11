<?php

declare(strict_types=1);

namespace App\WeatherChecker\Manager;

use App\WeatherChecker\Model\Response\WarningResponse;
use App\WeatherChecker\Repository\CachedWeatherWarningRepository;
use Carbon\Carbon;
use Exception;
use InvalidArgumentException;

class WeatherCheckManager
{
    public function __construct(private readonly CachedWeatherWarningRepository $repository)
    {
    }

    /**
     * @throws Exception
     */
    public function manage(string $placeCode, string $startDateTime, string $endDateTime): WarningResponse
    {
        if (empty($placeCode)) {
            throw new InvalidArgumentException('Place code cannot be empty');
        }

        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDateTime);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $endDateTime);

        return $this->repository->find($placeCode, $startDate, $endDate);
    }
}
