<?php

namespace App\Notifier\Processor;

use App\Notifier\Model\Notification;

/**
 * Interface NotificationProcessorInterface
 * @package App\Notifier\Processor
 */
interface NotificationProcessorInterface
{
    /**
     * @param  Notification[]   $notifications
     * @return void
     */
    public function process(array $notifications): void;
}
