<?php

declare(strict_types=1);

namespace App\WeatherChecker\Listener\WeatherUpdate;

use App\WeatherChecker\Repository\CachedWeatherRepository;
use App\WeatherChecker\Event\WeatherUpdated;
use Src\Weather\Repository\CachedWeatherForecastsRepository;

class RefreshWeatherCache
{
    public function __construct(
        private readonly CachedWeatherForecastsRepository $cachedWeatherRepository,
        private readonly CachedWeatherRepository $cachedWeatherWarningRepository,
    ) {
    }

    public function __invoke(WeatherUpdated $weatherUpdated): void
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
