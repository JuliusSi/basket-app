<?php

namespace App\Providers;

use App\Console\Commands\NewYearNotificationCommand;
use App\Console\Commands\WeatherForBasketBallNotificationCommand;
use App\Notifier\Manager\DefaultNotificationManager;
use App\Notifier\Manager\NotificationManagerInterface;
use App\Notifier\Processor\DefaultNotificationProcessor;
use App\Notifier\Service\NewYearNotificationService;
use App\Notifier\Service\WeatherForBasketBallNotificationService;
use Illuminate\Support\ServiceProvider;

/**
 * Class NotificationServiceProvider
 * @package App\Providers
 */
class NotificationManagerProvider  extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->when([NewYearNotificationCommand::class])
            ->needs(NotificationManagerInterface::class)
            ->give(function () {
                return new DefaultNotificationManager(
                    $this->app->make(NewYearNotificationService::class),
                    $this->app->make(DefaultNotificationProcessor::class)
                );
            });

        $this->app->when([WeatherForBasketBallNotificationCommand::class])
            ->needs(NotificationManagerInterface::class)
            ->give(function () {
                return new DefaultNotificationManager(
                    $this->app->make(WeatherForBasketBallNotificationService::class),
                    $this->app->make(DefaultNotificationProcessor::class)
                );
            });
    }
}
