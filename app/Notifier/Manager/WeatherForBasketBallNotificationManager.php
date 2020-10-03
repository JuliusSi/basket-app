<?php

namespace App\Notifier\Manager;

use App\Notifier\Model\Notification;
use App\Notifier\Processor\DefaultNotificationProcessor;
use App\Notifier\Service\WeatherForBasketBallNotificationService;

/**
 * Class WeatherForBasketBallNotificationManager
 * @package App\Notifier\Manager
 */
class WeatherForBasketBallNotificationManager
{
    /**
     * @var WeatherForBasketBallNotificationService
     */
    private WeatherForBasketBallNotificationService $notificationService;

    /**
     * @var DefaultNotificationProcessor
     */
    private DefaultNotificationProcessor $notificationProcessor;

    /**
     * WeatherForBasketBallNotificationManager constructor.
     * @param  WeatherForBasketBallNotificationService  $notificationService
     * @param  DefaultNotificationProcessor  $notificationProcessor
     */
    public function __construct(
        WeatherForBasketBallNotificationService $notificationService,
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
        return [$this->notificationService->getNotification()];
    }
}
