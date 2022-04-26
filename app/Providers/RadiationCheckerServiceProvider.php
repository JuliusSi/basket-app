<?php

declare(strict_types=1);

namespace App\Providers;

use App\RadiationChecker\Collector\RadiationInfoCollector;
use App\WeatherChecker\Collector\PastWeatherWarningCollector;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Src\Radiation\Repository\CachedRadiationRepository;
use Src\Radiation\Repository\GolfCharlieRepository;

class RadiationCheckerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('radiation_checker.radiation_info_repositories_collection', function ($app) {
            return new Collection(
                [
                    $app->make(CachedRadiationRepository::class),
                    $app->make(GolfCharlieRepository::class),
                ]
            );
        });

        $this->app->singleton(RadiationInfoCollector::class, function ($app) {
            return new RadiationInfoCollector(
                $app->make('radiation_checker.radiation_info_repositories_collection')
            );
        });
    }
}
