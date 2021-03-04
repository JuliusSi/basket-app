<?php

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;

/**
 * Interface NotificationServiceInterface
 * @package App\Notifier\Service
 */
interface NotificationServiceInterface
{
    /**
     * @return Notification[]
     */
    public function getNotifications(): array;
}
