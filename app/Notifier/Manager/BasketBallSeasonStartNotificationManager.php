<?php

namespace App\Notifier\Manager;

use App\Notifier\Model\Notification;
use App\Notifier\Processor\DefaultNotificationProcessor;
use Core\Storage\Service\LocalStorageService;

/**
 * Class BasketBallSeasonStartNotificationManager
 * @package App\Notifier\Manager
 */
class BasketBallSeasonStartNotificationManager implements NotificationManagerInterface
{
    /**
     * @var DefaultNotificationProcessor
     */
    private DefaultNotificationProcessor $processor;

    /**
     * @var LocalStorageService
     */
    private LocalStorageService $localStorageService;

    /**
     * BasketBallSeasonStartNotificationManager constructor.
     * @param  DefaultNotificationProcessor  $processor
     * @param  LocalStorageService  $localStorageService
     */
    public function __construct(DefaultNotificationProcessor $processor, LocalStorageService $localStorageService)
    {
        $this->processor = $processor;
        $this->localStorageService = $localStorageService;
    }

    /**
     * @return void
     */
    public function manage(): void
    {
        $this->processor->process([$this->getNotification()]);
    }

    /**
     * @return Notification
     */
    private function getNotification(): Notification
    {
        $notification = new Notification();
        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));
        $notification->setContent($this->getContent());
        $notification->setImageUrl($this->getFileUrl(config('memes.kyrie_irving_air_guitar_gif_url')));

        return $notification;
    }

    /**
     * @return string
     */
    private function getContent(): string
    {
        $startNotify = config('notification.weather_for_basketball.start_notify');
        $notificationTime = config('notification.weather_for_basketball.time_to_notify');

        return __('notification.basketball_season_start',
            ['startDate' => $startNotify, 'notificationTime' => $notificationTime]
        );
    }

    /**
     * @param  string  $fileName
     * @param  string  $directory
     * @return string|null
     */
    private function getFileUrl(string $fileName, string $directory = LocalStorageService::DIRECTORY_MEMES): ?string
    {
        return $this->localStorageService->findFileUrl($fileName, $directory);
    }
}
