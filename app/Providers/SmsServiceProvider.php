<?php

declare(strict_types=1);

namespace App\Providers;

use App\Console\Commands\SmsSendingCommand;
use App\Notifier\Collection\SmsNotifier;
use Illuminate\Support\ServiceProvider;
use Src\Sms\Sender\ESmsSender;
use Src\Sms\Sender\SmsSender;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when([SmsNotifier::class])
            ->needs(SmsSender::class)
            ->give(function () {
                return $this->app->make(ESmsSender::class);
            });

        $this->app->when([SmsSendingCommand::class])
            ->needs(SmsSender::class)
            ->give(function () {
                return $this->app->make(ESmsSender::class);
            });
    }
}
