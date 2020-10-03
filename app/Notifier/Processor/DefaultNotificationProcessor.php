<?php

namespace App\Notifier\Processor;

use App\Notifier\Collection\NotifierInterface;
use App\Notifier\Collection\WeatherForBasketBallNotifierCollection;
use App\Notifier\Model\Notification;

/**
 * Class DefaultNotificationProcessor
 * @package App\Notifier\Processor
 */
class DefaultNotificationProcessor implements NotificationProcessorInterface
{
    /**
     * @var WeatherForBasketBallNotifierCollection
     */
    private WeatherForBasketBallNotifierCollection $collection;

    /**
     * DefaultNotificationProcessor constructor.
     * @param  WeatherForBasketBallNotifierCollection  $collection
     */
    public function __construct(WeatherForBasketBallNotifierCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param  Notification[]  $notifications
     */
    public function process(array $notifications): void
    {
        $this->applyNotifiers($notifications);
    }

    /**
     * @param  Notification[]  $notifications
     */
    private function applyNotifiers(array $notifications): void
    {
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
}
