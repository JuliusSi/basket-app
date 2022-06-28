<?php

declare(strict_types=1);

namespace App\WeatherChecker\Manager;

use App\WeatherChecker\Model\Response\WeatherResponse;
use App\WeatherChecker\Repository\CachedWeatherRepository;
use Carbon\Carbon;
use Exception;
use InvalidArgumentException;

class WeatherCheckManager
{
    public function __construct(private readonly CachedWeatherRepository $repository)
    {
    }

    /**
     * @throws Exception
     */
    public function manage(string $placeCode, string $startDateTime, string $endDateTime): WeatherResponse
    {
        if (empty($placeCode)) {
            throw new InvalidArgumentException('Place code cannot be empty');
        }

        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDateTime);
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $endDateTime);

        return $this->repository->find($placeCode, $startDate, $endDate);
    }
}
