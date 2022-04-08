<?php

namespace App\Notifier\Builder;

use App\Notifier\Model\Notification;

/**
 * Interface NotificationServiceInterface.
 */
interface NotificationBuilder
{
    /**
     * @return Notification[]
     */
    public function getNotifications(): array;
}
