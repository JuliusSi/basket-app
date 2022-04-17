<?php

declare(strict_types=1);

namespace App\Notifier\Manager;

use App\Notifier\Builder\NotificationBuilder;
use App\Notifier\Model\Notification;
use App\Notifier\Processor\DefaultNotificationProcessor;

class DefaultNotificationManager implements NotificationManagerInterface
{
    private NotificationBuilder $notificationService;

    private DefaultNotificationProcessor $notificationProcessor;

    public function __construct(
        NotificationBuilder $notificationBuilder,
        DefaultNotificationProcessor $notificationProcessor
    ) {
        $this->notificationService = $notificationBuilder;
        $this->notificationProcessor = $notificationProcessor;
    }

    public function manage(): void
    {
        $notifications = $this->getNotifications();
        if (!$notifications) {
            return;
        }

        $this->notificationProcessor->process($notifications);
    }

    /**
     * @return Notification[]
     */
    private function getNotifications(): array
    {
        return $this->notificationService->getNotifications();
    }
}
