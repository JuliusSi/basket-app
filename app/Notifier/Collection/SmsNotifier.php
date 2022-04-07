<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;
use function in_array;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Service\SmsSendingService;

class SmsNotifier implements NotifierInterface
{
    public function __construct(private SmsSendingService $smsSendingService)
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
            $this->smsSendingService->send(
                $notification->getNotifier(),
                $notification->getSmsRecipients(),
                [$notification->getContent()]
            );
        } catch (SmsSendingException $exception) {
            // needs handling?
        }
    }

    private function canNotify(Notification $notification): bool
    {
        if ($notification->getNotifier() !== config('sms.weather_for_basketball.sender_name')) {
            return true;
        }

        if (in_array(now()->dayOfWeekIso, [5, 6, 7], true)) {
            return true;
        }

        return false;
    }
}
