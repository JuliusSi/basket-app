<?php

declare(strict_types=1);

namespace App\WeatherChecker\Listener\WeatherUpdate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Src\Weather\Event\WeatherUpdated;

class NotifyAboutWeatherForBasketBall implements ShouldQueue
{
    public function handle(WeatherUpdated $weatherUpdated): void
    {
        if ($this->canNotify($weatherUpdated)) {
            Artisan::call('weatherForBasketBall:notify');
        }
    }

    private function canNotify(WeatherUpdated $weatherUpdated): bool
    {
        return $weatherUpdated->response->getPlace()->getCode() === config('notification.weather_for_basketball.place_code_to_check');
    }
}
