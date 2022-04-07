<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;
use Core\Logger\LogDispatcher;
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
        LogDispatcher::dispatch(Log::create($notification->getContent()));
    }
}
