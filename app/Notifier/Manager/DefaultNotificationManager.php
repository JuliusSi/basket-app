<?php

namespace App\Notifier\Manager;

use App\Notifier\Model\Notification;
use App\Notifier\Processor\DefaultNotificationProcessor;
use App\Notifier\Service\NotificationServiceInterface;

class DefaultNotificationManager implements NotificationManagerInterface
{
    private NotificationServiceInterface $notificationService;

    private DefaultNotificationProcessor $notificationProcessor;

    /**
     * DefaultNotificationManager constructor.
     */
    public function __construct(
        NotificationServiceInterface $notificationService,
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
