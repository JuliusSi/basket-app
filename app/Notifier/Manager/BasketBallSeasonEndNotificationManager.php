<?php

namespace App\Notifier\Manager;

use App\Notifier\Collection\NotifierInterface;
use App\Notifier\Collection\WeatherForBasketBallNotifierCollection;
use App\Notifier\Model\Notification;

/**
 * Class BasketBallSeasonEndNotificationManager
 * @package App\Notifier\Manager
 */
class BasketBallSeasonEndNotificationManager
{
    /**
     * @var WeatherForBasketBallNotifierCollection
     */
    private WeatherForBasketBallNotifierCollection $collection;

    /**
     * BasketBallSeasonEndNotificationManager constructor.
     * @param  WeatherForBasketBallNotifierCollection  $collection
     */
    public function __construct(WeatherForBasketBallNotifierCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return void
     */
    public function manage(): void
    {
        $this->applyNotifiers([$this->getNotification()]);
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

    /**
     * @return Notification
     */
    private function getNotification(): Notification
    {
        $notification = new Notification();
        $notification->setSmsRecipients(config('notification.weather_for_basketball.sms_recipients'));
        $notification->setContent($this->getContent());
        $notification->setImageUrl(config('memes.vince_carter_its_over_gif_url'));

        return $notification;
    }

    /**
     * @return string
     */
    private function getContent(): string
    {
        $startNotify = config('notification.weather_for_basketball.start_notify');
        $endNotify = config('notification.weather_for_basketball.end_notify');

        return __('notification.basketball_season_end', ['endDate' => $endNotify, 'startDate' => $startNotify]);
    }
}
