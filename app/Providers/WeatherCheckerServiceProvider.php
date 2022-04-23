<?php

declare(strict_types=1);

namespace App\Providers;

use App\WeatherChecker\Collection\AirTemperatureChecker;
use App\WeatherChecker\Collection\CheckerCollection;
use App\WeatherChecker\Collection\ConditionCodeChecker;
use App\WeatherChecker\Collection\PastPrecipitationChecker;
use App\WeatherChecker\Collection\PrecipitationChecker;
use App\WeatherChecker\Collection\WindChecker;
use App\WeatherChecker\Collector\WarningCollector;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Service\WeatherService;
use Illuminate\Support\ServiceProvider;

class WeatherCheckerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('future_weather_checkers', function ($app) {
            $collection = new CheckerCollection();
            $collection->setItems([
                $app->make(AirTemperatureChecker::class),
                $app->make(WindChecker::class),
                $app->make(PrecipitationChecker::class),
                $app->make(ConditionCodeChecker::class),
            ]);

            return $collection;
        });

        $this->app->singleton('past_weather_checkers', function ($app) {
            $collection = new CheckerCollection();
            $collection->setItems([
                $app->make(PastPrecipitationChecker::class),
            ]);

            return $collection;
        });

        $this->app->singleton(WeatherCheckManager::class, function ($app) {
            return new WeatherCheckManager(
                $app->make(WeatherService::class),
                $app->make('past_weather_checkers'),
                $app->make('future_weather_checkers'),
                $app->make(WarningCollector::class)
            );
        });
    }
}
