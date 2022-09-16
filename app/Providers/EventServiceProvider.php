<?php

namespace App\Providers;

use App\Chat\Listener\NotifyAboutNewUser;
use App\Notifier\Event\ChatNotificationCreated;
use App\Notifier\Event\FacebookNotificationCreated;
use App\Notifier\Event\SmsNotificationCreated;
use App\Notifier\Listener\CreateFacebookPost;
use App\Notifier\Listener\NotifyAboutWeatherForBasketball;
use App\Notifier\Listener\SendChatMessage;
use App\Notifier\Listener\SendSmsNotifications;
use App\Payment\Event\SmsPaymentCompleted;
use App\User\Listener\CreateNewUserGreetingNotification;
use App\User\Listener\CreateSmsPaymentNotification;
use App\User\Listener\UpdateLastLoginAt;
use App\User\Listener\UpdateSmsBalance;
use App\WeatherChecker\Event\WeatherForBasketballChecked;
use App\WeatherChecker\Event\WeatherUpdated;
use App\WeatherChecker\Listener\WeatherUpdate\CheckWeatherForBasketballForSpecialPlaceCode;
use App\WeatherChecker\Listener\WeatherUpdate\RefreshWeatherCache;
use Core\Logger\Event\ActionDone;
use Core\Logger\Listener\LogAction;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
            NotifyAboutNewUser::class,
            CreateNewUserGreetingNotification::class,
        ],
        Login::class => [
            UpdateLastLoginAt::class,
        ],
        ActionDone::class => [
            LogAction::class,
        ],
        WeatherUpdated::class => [
            RefreshWeatherCache::class,
            CheckWeatherForBasketballForSpecialPlaceCode::class,
        ],
        WeatherForBasketballChecked::class => [
            NotifyAboutWeatherForBasketball::class,
        ],
        FacebookNotificationCreated::class => [
            CreateFacebookPost::class,
        ],
        ChatNotificationCreated::class => [
            SendChatMessage::class,
        ],
        SmsNotificationCreated::class => [
            SendSmsNotifications::class,
        ],
        SmsPaymentCompleted::class => [
            CreateSmsPaymentNotification::class,
            UpdateSmsBalance::class,
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
