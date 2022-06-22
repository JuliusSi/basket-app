<?php

declare(strict_types=1);

namespace App\WeatherChecker\Listener\WeatherUpdate;

use App\WeatherChecker\Event\WeatherForBasketballChecked;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\WeatherChecker\Event\WeatherUpdated;

class NotifyAboutWeatherFotBasketballUpdate implements ShouldQueue
{
    public function handle(WeatherUpdated $weatherUpdated): void
    {
        if ($this->canNotify($weatherUpdated)) {
            WeatherForBasketballChecked::dispatch($weatherUpdated->response);
        }
    }

    private function canNotify(WeatherUpdated $weatherUpdated): bool
    {
        return $weatherUpdated->response->getPlaceCode() === config('notification.weather_for_basketball.place_code_to_check');
    }
}
