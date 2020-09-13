<?php

namespace App\Providers;

use App\Notifier\Collection\WeatherForBasketBallFacebookPageNotifier;
use App\Notifier\Collection\WeatherForBasketBallNotifierCollection;
use App\Notifier\Collection\WeatherForBasketBallSmsNotifier;
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
    }
}
