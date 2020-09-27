<?php

namespace App\Providers;

use App\Notifier\Collection\WeatherForBasketBallFacebookPageNotifier;
use App\Notifier\Collection\WeatherForBasketBallNotifierCollection;
use App\Notifier\Collection\WeatherForBasketBallSmsNotifier;
use App\WeatherChecker\Collection\AirTemperatureChecker;
use App\WeatherChecker\Collection\CheckerCollection;
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
                $app->make(WeatherForBasketBallSmsNotifier::class),
                $app->make(WeatherForBasketBallFacebookPageNotifier::class),
            ]);

            return $collection;
        });

        $this->app->singleton(CheckerCollection::class, function ($app) {
            $collection = new CheckerCollection();
            $collection->setItems([
                $app->make(AirTemperatureChecker::class),
                $app->make(WindChecker::class),
                $app->make(PrecipitationChecker::class),
            ]);

            return $collection;
        });
    }
}
