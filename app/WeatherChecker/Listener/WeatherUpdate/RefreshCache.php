<?php

declare(strict_types=1);

namespace App\WeatherChecker\Listener\WeatherUpdate;

use App\WeatherChecker\Repository\CachedWeatherWarningRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Weather\Event\WeatherUpdated;
use Src\Weather\Repository\CachedWeatherRepository;

class RefreshCache implements ShouldQueue
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