<?php

declare(strict_types=1);

namespace App\Providers;

use App\WeatherChecker\Collection\AirTemperatureChecker;
use App\WeatherChecker\Collection\ConditionCodeChecker;
use App\WeatherChecker\Collection\HumidityChecker;
use App\WeatherChecker\Collection\PastPrecipitationChecker;
use App\WeatherChecker\Collection\PrecipitationChecker;
use App\WeatherChecker\Collection\WindChecker;
use App\WeatherChecker\Collector\Warning\PastWeatherWarningCollector;
use App\WeatherChecker\Collector\Warning\WeatherWarningCollector;
use App\WeatherChecker\Filter\ForecastsByDateFilter;
use App\WeatherChecker\Repository\CachedWeatherWarningRepository;
use App\WeatherChecker\Repository\WeatherWarningRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Src\Weather\Repository\CachedWeatherRepository;

class WeatherCheckerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('weather_checker.checker.weather_checkers_collection', function ($app) {
            return new Collection(
                [
                    $app->make(AirTemperatureChecker::class),
                    $app->make(WindChecker::class),
                    $app->make(PrecipitationChecker::class),
                    $app->make(ConditionCodeChecker::class),
                    $app->make(HumidityChecker::class),
                ]
            );
        });

        $this->app->singleton('weather_checker.checker.past_weather_checkers_collection', function ($app) {
            return new Collection(
                [
                    $app->make(PastPrecipitationChecker::class),
                ]
            );
        });

        $this->app->singleton(PastWeatherWarningCollector::class, function ($app) {
            return new PastWeatherWarningCollector(
                $app->make('weather_checker.checker.past_weather_checkers_collection')
            );
        });

        $this->app->singleton(WeatherWarningCollector::class, function ($app) {
            return new WeatherWarningCollector(
                $app->make('weather_checker.checker.weather_checkers_collection')
            );
        });

        $this->app->singleton('weather_checker.collector.warning_collectors_collection', function ($app) {
            return new Collection(
                [
                    $app->make(PastWeatherWarningCollector::class),
                    $app->make(WeatherWarningCollector::class),
                ]
            );
        });

        $this->app->singleton(CachedWeatherWarningRepository::class, function ($app) {
            return new CachedWeatherWarningRepository(
                $app->make('weather_checker.collector.warning_collectors_collection'),
                $app->make(CachedWeatherRepository::class),
                $app->make(ForecastsByDateFilter::class),
            );
        });

        $this->app->singleton(WeatherWarningRepository::class, function ($app) {
            return new WeatherWarningRepository(
                $app->make('weather_checker.collector.warning_collectors_collection'),
                $app->make(CachedWeatherRepository::class),
                $app->make(ForecastsByDateFilter::class),
            );
        });
    }
}
