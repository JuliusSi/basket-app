<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;

interface NotifierInterface
{
    /**
     * @param Notification[] $notifications
     */
    public function notify(array $notifications): void;
}
