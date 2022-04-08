<?php

declare(strict_types=1);

namespace App\Providers;

use App\Console\Commands\BasketBallSeasonEndNotificationCommand;
use App\Console\Commands\BasketBallSeasonStartNotificationCommand;
use App\Console\Commands\NewYearNotificationCommand;
use App\Console\Commands\RadiationInfoNotificationCommand;
use App\Console\Commands\UserWeatherForBasketBallNotificationCommand;
use App\Console\Commands\WeatherForBasketBallNotificationCommand;
use App\Notifier\Manager\DefaultNotificationManager;
use App\Notifier\Manager\NotificationManagerInterface;
use App\Notifier\Processor\DefaultNotificationProcessor;
use App\Notifier\Service\BasketBallSeasonEndNotificationService;
use App\Notifier\Service\BasketBallSeasonStartNotificationService;
use App\Notifier\Service\NewYearNotificationService;
use App\Notifier\Service\RadiationInfoNotificationService;
use App\Notifier\Service\UserWeatherForBasketBallNotificationService;
use App\Notifier\Service\WeatherForBasketBallNotificationService;
use Illuminate\Support\ServiceProvider;

class NotificationManagerProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('weather_for_basketball_notification_processor', function ($app) {
            return new DefaultNotificationProcessor($app->make('weather_for_basketball_notifier_collection'));
        });

        $this->app->singleton('user_weather_for_basketball_notification_processor', function ($app) {
            return new DefaultNotificationProcessor($app->make('user_weather_for_basketball_notifier_collection'));
        });

        $this->app->singleton('radiation_notification_processor', function ($app) {
            return new DefaultNotificationProcessor($app->make('radiation_notifier_collection'));
        });

        $this->app->when([NewYearNotificationCommand::class])
            ->needs(NotificationManagerInterface::class)
            ->give(function () {
                return new DefaultNotificationManager(
                    $this->app->make(NewYearNotificationService::class),
                    $this->app->make('weather_for_basketball_notification_processor')
                );
            })
        ;

        $this->app->when([UserWeatherForBasketBallNotificationCommand::class])
            ->needs(NotificationManagerInterface::class)
            ->give(function () {
                return new DefaultNotificationManager(
                    $this->app->make(UserWeatherForBasketBallNotificationService::class),
                    $this->app->make('user_weather_for_basketball_notification_processor')
                );
            })
        ;

        $this->app->when([WeatherForBasketBallNotificationCommand::class])
            ->needs(NotificationManagerInterface::class)
            ->give(function () {
                return new DefaultNotificationManager(
                    $this->app->make(WeatherForBasketBallNotificationService::class),
                    $this->app->make('weather_for_basketball_notification_processor')
                );
            })
        ;

        $this->app->when([RadiationInfoNotificationCommand::class])
            ->needs(NotificationManagerInterface::class)
            ->give(function () {
                return new DefaultNotificationManager(
                    $this->app->make(RadiationInfoNotificationService::class),
                    $this->app->make('radiation_notification_processor')
                );
            })
        ;

        $this->app->when([BasketBallSeasonEndNotificationCommand::class])
            ->needs(NotificationManagerInterface::class)
            ->give(function () {
                return new DefaultNotificationManager(
                    $this->app->make(BasketBallSeasonEndNotificationService::class),
                    $this->app->make('weather_for_basketball_notification_processor')
                );
            })
        ;

        $this->app->when([BasketBallSeasonStartNotificationCommand::class])
            ->needs(NotificationManagerInterface::class)
            ->give(function () {
                return new DefaultNotificationManager(
                    $this->app->make(BasketBallSeasonStartNotificationService::class),
                    $this->app->make('weather_for_basketball_notification_processor')
                );
            })
        ;
    }
}
