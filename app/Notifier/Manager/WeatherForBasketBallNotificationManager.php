<?php

namespace App\Notifier\Manager;

use App\Notifier\Collection\NotifierInterface;
use App\Notifier\Collection\WeatherForBasketBallNotifierCollection;
use App\Notifier\Model\Notification;
use App\Notifier\Service\WeatherForBasketBallNotificationService;

/**
 * Class WeatherForBasketBallNotificationManager
 * @package App\Notifier\Manager
 */
class WeatherForBasketBallNotificationManager
{
    /**
     * @var WeatherForBasketBallNotifierCollection
     */
    private WeatherForBasketBallNotifierCollection $collection;

    /**
     * @var WeatherForBasketBallNotificationService
     */
    private WeatherForBasketBallNotificationService $notificationService;

    /**
     * WeatherForBasketBallNotificationManager constructor.
     * @param  WeatherForBasketBallNotifierCollection  $collection
     * @param  WeatherForBasketBallNotificationService  $notificationService
     */
    public function __construct(
        WeatherForBasketBallNotifierCollection $collection,
        WeatherForBasketBallNotificationService $notificationService
    ) {
        $this->collection = $collection;
        $this->notificationService = $notificationService;
    }

    /**
     * @return void
     */
    public function manage(): void
    {
        $notifications = $this->getNotifications();
        foreach ($this->getNotifiers() as $notifier) {
            $notifier->notify($notifications);
        }
    }

    /**
     * @return NotifierInterface[]
     */
    private function getNotifiers(): array
    {
        return $this->collection->getItems();
    }

    /**
     * @return Notification[]
     */
    private function getNotifications(): array
    {
        return [$this->notificationService->getNotification()];
    }
}
