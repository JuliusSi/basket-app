<?php

namespace App\Notifier\Manager;

use App\Notifier\Model\Notification;
use App\Notifier\Processor\DefaultNotificationProcessor;
use App\Notifier\Builder\NotificationBuilder;

class DefaultNotificationManager implements NotificationManagerInterface
{
    private NotificationBuilder $notificationService;

    private DefaultNotificationProcessor $notificationProcessor;

    /**
     * DefaultNotificationManager constructor.
     */
    public function __construct(
        NotificationBuilder $notificationService,
        DefaultNotificationProcessor $notificationProcessor
    ) {
        $this->notificationService = $notificationService;
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
