<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Service\SmsSendingService;

class SmsNotifier implements NotifierInterface
{
    public function __construct(private SmsSendingService $smsSendingService)
    {
    }

    /**
     * @param  Notification[]  $notifications
     * @return void
     */
    public function notify(array $notifications): void
    {
        foreach ($notifications as $notification) {
            $this->sendSms($notification);
        }
    }

    private function sendSms(Notification $notification): void
    {
        try {
            $this->smsSendingService->send(
                $notification->getNotifier(),
                $notification->getSmsRecipients(),
                [$notification->getContent()]
            );
        } catch (SmsSendingException $exception) {
            // needs handling?
        }

    }
}
