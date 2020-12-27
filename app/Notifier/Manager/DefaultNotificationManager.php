<?php

namespace App\Notifier\Manager;

use App\Notifier\Model\Notification;
use App\Notifier\Processor\DefaultNotificationProcessor;
use App\Notifier\Service\NotificationServiceInterface;

/**
 * Class DefaultNotificationManager
 * @package App\Notifier\Manager
 */
class DefaultNotificationManager implements NotificationManagerInterface
{
    /**
     * @var NotificationServiceInterface
     */
    private NotificationServiceInterface $notificationService;

    /**
     * @var DefaultNotificationProcessor
     */
    private DefaultNotificationProcessor $notificationProcessor;

    /**
     * DefaultNotificationManager constructor.
     * @param  NotificationServiceInterface  $notificationService
     * @param  DefaultNotificationProcessor  $notificationProcessor
     */
    public function __construct(
        NotificationServiceInterface $notificationService,
        DefaultNotificationProcessor $notificationProcessor
    ) {
        $this->notificationService = $notificationService;
        $this->notificationProcessor = $notificationProcessor;
    }

    /**
     * @return void
     */
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
