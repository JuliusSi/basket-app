<?php

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;

/**
 * Interface NotificationServiceInterface.
 */
interface NotificationServiceInterface
{
    /**
     * @return Notification[]
     */
    public function getNotifications(): array;
}
