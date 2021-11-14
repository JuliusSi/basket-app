<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;
use Core\Logger\Event\ActionDone;
use Core\Logger\Model\Log;

class LogNotifier implements NotifierInterface
{
    public function notify(array $notifications): void
    {
        $this->logNotifications($notifications);
    }

    private function logNotifications(array $notifications): void
    {
        foreach ($notifications as $notification) {
            $this->logNotification($notification);
        }
    }

    private function logNotification(Notification $notification): void
    {
        event(new ActionDone(Log::create($notification->getContent())));
    }
}
