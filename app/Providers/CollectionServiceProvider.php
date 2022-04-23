<?php

declare(strict_types=1);

namespace App\Providers;

use App\Notifier\Collection\ChatNotifier;
use App\Notifier\Collection\FacebookPageNotifier;
use App\Notifier\Collection\LogNotifier;
use App\Notifier\Collection\SmsNotifier;
use App\WeatherChecker\Collection\AirTemperatureChecker;
use App\WeatherChecker\Collection\CheckerCollection;
use App\WeatherChecker\Collection\ConditionCodeChecker;
use App\WeatherChecker\Collection\PrecipitationChecker;
use App\WeatherChecker\Collection\WindChecker;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            'weather_for_basketball_notifier_collection',
            function ($app) {
                return new Collection(
                    [
                        $app->make(SmsNotifier::class),
                        $app->make(FacebookPageNotifier::class),
                        $app->make(ChatNotifier::class),
                        $app->make(LogNotifier::class),
                    ]
                );
            }
        );

        $this->app->singleton(
            'user_weather_for_basketball_notifier_collection',
            function ($app) {
                return new Collection(
                    [
                        $app->make(SmsNotifier::class),
                    ]
                );
            }
        );

        $this->app->singleton(
            'radiation_notifier_collection',
            function ($app) {
                return new Collection(
                    [
                        $app->make(SmsNotifier::class),
                        $app->make(ChatNotifier::class),
                    ]
                );
            }
        );
    }
}
