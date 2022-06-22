<?php

declare(strict_types=1);

namespace App\WeatherChecker\Listener\WeatherUpdate;

use App\WeatherChecker\Repository\CachedWeatherWarningRepository;
use App\WeatherChecker\Event\WeatherUpdated;
use Src\Weather\Repository\CachedWeatherRepository;

class RefreshCache
{
    public function __construct(
        private readonly CachedWeatherRepository $cachedWeatherRepository,
        private readonly CachedWeatherWarningRepository $cachedWeatherWarningRepository,
    ) {
    }

    public function handle(WeatherUpdated $weatherUpdated): void
    {
        $placeCode = $weatherUpdated->response->getPlaceCode();

        $this->cachedWeatherRepository->refreshCache($placeCode);
        $this->cachedWeatherWarningRepository->refreshCache(
            $placeCode,
            now(),
            now()->addHours(config('weather.rules.hours_to_check'))
        );
    }
}
