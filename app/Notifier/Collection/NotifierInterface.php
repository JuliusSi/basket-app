<?php

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;

/**
 * Interface NotifierInterface
 * @package App\Notifier\Collection
 */
interface NotifierInterface
{
    /**
     * @param  Notification[]  $notifications
     */
    public function notify(array $notifications): void;
}
