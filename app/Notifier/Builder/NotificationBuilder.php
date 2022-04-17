<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Notifier\Model\Notification;

interface NotificationBuilder
{
    /**
     * @return Notification[]
     */
    public function getNotifications(): array;
}
