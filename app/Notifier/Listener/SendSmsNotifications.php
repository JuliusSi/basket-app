<?php

declare(strict_types=1);

namespace App\Notifier\Listener;

use App\Notifier\Event\SmsNotificationCreated;
use App\Notifier\Model\SmsNotification;
use Illuminate\Support\Facades\Log;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Sender\SmsSender;

class SendSmsNotifications
{
    public function __construct(private readonly SmsSender $sender)
    {
    }

    public function __invoke(SmsNotificationCreated $notificationCreated): void
    {
        $this->sendSms($notificationCreated->notification);
    }

    private function sendSms(SmsNotification $notification): void
    {
        try {
            $this->sender->sendQueued($notification->sender(), $notification->recipients(), [$notification->content()]);
        } catch (SmsSendingException $exception) {
            Log::error($exception->getMessage());
        }
    }
}
