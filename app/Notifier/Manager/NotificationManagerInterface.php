<?php

declare(strict_types=1);

namespace App\Notifier\Manager;

/**
 * Interface NotificationManagerInterface
 * @package App\Notifier\Manager
 */
interface NotificationManagerInterface
{
    /**
     * @return void
     */
    public function manage(): void;
}
