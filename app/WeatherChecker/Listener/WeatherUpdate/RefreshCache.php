<?php

declare(strict_types=1);

namespace App\WeatherChecker\Listener\WeatherUpdate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Weather\Event\WeatherUpdated;
use Src\Weather\Repository\CachedWeatherRepository;

class RefreshCache implements ShouldQueue
{
    public function __construct(private readonly CachedWeatherRepository $cachedWeatherRepository)
    {
    }

    public function handle(WeatherUpdated $weatherUpdated): void
    {
        $this->cachedWeatherRepository->refreshCache($weatherUpdated->response->getPlace()->getCode());
    }
}
