<?php

namespace App\Providers;

use Core\Logger\Listener\LogAction;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use \Core\Logger\Event\ActionDone;
use Src\Sms\Event\ESmsCreated;
use Src\Sms\Listener\SendESms;

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
        ESmsCreated::class => [
          SendESms::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
