<?php

declare(strict_types=1);

namespace App\Notifier\Manager;

interface NotificationManagerInterface
{
    public function manage(): void;
}
