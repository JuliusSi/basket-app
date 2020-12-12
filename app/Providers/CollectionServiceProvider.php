<?php

namespace App\Providers;

use App\Notifier\Collection\ChatNotifier;
use App\Notifier\Collection\FacebookPageNotifier;
use App\Notifier\Collection\WeatherForBasketBallNotifierCollection;
use App\Notifier\Collection\SmsNotifier;
use App\WeatherChecker\Collection\AirTemperatureChecker;
use App\WeatherChecker\Collection\CheckerCollection;
use App\WeatherChecker\Collection\ConditionCodeChecker;
use App\WeatherChecker\Collection\PrecipitationChecker;
use App\WeatherChecker\Collection\WindChecker;
use Illuminate\Support\ServiceProvider;

/**
 * Class CollectionServiceProvider
 * @package App\Providers
 */
class CollectionServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(WeatherForBasketBallNotifierCollection::class, function ($app) {
            $collection = new WeatherForBasketBallNotifierCollection();
            $collection->setItems([
                $app->make(SmsNotifier::class),
                $app->make(FacebookPageNotifier::class),
                $app->make(ChatNotifier::class),
            ]);

            return $collection;
        });

        $this->app->singleton(CheckerCollection::class, function ($app) {
            $collection = new CheckerCollection();
            $collection->setItems([
                $app->make(AirTemperatureChecker::class),
                $app->make(WindChecker::class),
                $app->make(PrecipitationChecker::class),
                $app->make(ConditionCodeChecker::class),
            ]);

            return $collection;
        });
    }
}
