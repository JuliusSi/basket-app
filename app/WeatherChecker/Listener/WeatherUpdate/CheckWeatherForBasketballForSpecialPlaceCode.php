<?php

declare(strict_types=1);

namespace App\WeatherChecker\Listener\WeatherUpdate;

use App\WeatherChecker\Event\WeatherUpdated;
use Illuminate\Support\Facades\Artisan;

class CheckWeatherForBasketballForSpecialPlaceCode
{
    public function __invoke(WeatherUpdated $weatherUpdated): void
    {
        if ($this->canCheck($weatherUpdated)) {
            Artisan::call('weather:check-weather-for-basketball');
        }
    }

    private function canCheck(WeatherUpdated $weatherUpdated): bool
    {
        return $weatherUpdated->response->getPlaceCode() === config('notification.weather_for_basketball.place_code_to_check');
    }
}
