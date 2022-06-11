<?php

namespace App\Providers;

use App\WeatherChecker\Listener\WeatherUpdate\NotifyAboutWeatherForBasketBall;
use App\WeatherChecker\Listener\WeatherUpdate\RefreshCache;
use Core\Logger\Event\ActionDone;
use Core\Logger\Listener\LogAction;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Src\Weather\Event\WeatherUpdated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ActionDone::class => [
            LogAction::class,
        ],
        WeatherUpdated::class => [
            RefreshCache::class,
            NotifyAboutWeatherForBasketBall::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
