<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;
use Illuminate\Support\Facades\Log;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Service\SmsSendingService;

class SmsNotifier implements NotifierInterface
{
    public function __construct(private readonly SmsSendingService $smsSendingService)
    {
    }

    /**
     * @param Notification[] $notifications
     */
    public function notify(array $notifications): void
    {
        foreach ($notifications as $notification) {
            if ($this->canNotify($notification)) {
                $this->sendSms($notification);
            }
        }
    }

    private function sendSms(Notification $notification): void
    {
        try {
            $this->smsSendingService->sendQueued(
                $notification->getNotifier(),
                $notification->getSmsRecipients(),
                [$notification->getContent()]
            );
        } catch (SmsSendingException $exception) {
            Log::error($exception->getMessage());
        }
    }

    private function canNotify(Notification $notification): bool
    {
        if (!$notification->getSmsRecipients()) {
            return false;
        }

        return true;
    }
}
