<?php

declare(strict_types=1);

namespace App\Providers;

use App\Console\Commands\SmsSendingCommand;
use App\Notifier\Collection\SmsNotifier;
use Illuminate\Support\ServiceProvider;
use Src\Sms\Service\ESmsSendingService;
use Src\Sms\Service\SmsSendingService;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when([SmsNotifier::class])
            ->needs(SmsSendingService::class)
            ->give(function () {
                return $this->app->make(ESmsSendingService::class);
            });

        $this->app->when([SmsSendingCommand::class])
            ->needs(SmsSendingService::class)
            ->give(function () {
                return $this->app->make(ESmsSendingService::class);
            });
    }
}
