<?php

namespace App\Notifier\Manager;

use App\Notifier\Collection\NotifierInterface;
use App\Notifier\Collection\WeatherForBasketBallNotifierCollection;
use App\Notifier\Model\Notification;
use App\Notifier\Processor\DefaultNotificationProcessor;

/**
 * Class BasketBallSeasonEndNotificationManager
 * @package App\Notifier\Manager
 */
class BasketBallSeasonEndNotificationManager
{
    /**
     * @var DefaultNotificationProcessor
     */
    private DefaultNotificationProcessor $notificationProcessor;

    /**
     * BasketBallSeasonEndNotificationManager constructor.
     * @param  DefaultNotificationProcessor  $notificationProcessor
     */
    public function __construct(DefaultNotificationProcessor $notificationProcessor)
    {
        $this->notificationProcessor = $notificationProcessor;
    }

    /**
     * @return void
     */
    public function manage(): void
    {
        $this->notificationProcessor->process([$this->getNotification()]);
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
