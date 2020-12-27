<?php

namespace App\Notifier\Manager;

use App\Notifier\Model\Notification;
use App\Notifier\Processor\DefaultNotificationProcessor;
use Core\Storage\Service\LocalStorageService;

/**
 * Class BasketBallSeasonEndNotificationManager
 * @package App\Notifier\Manager
 */
class BasketBallSeasonEndNotificationManager implements NotificationManagerInterface
{
    /**
     * @var DefaultNotificationProcessor
     */
    private DefaultNotificationProcessor $notificationProcessor;

    /**
     * @var LocalStorageService
     */
    private LocalStorageService $localStorageService;

    /**
     * BasketBallSeasonEndNotificationManager constructor.
     * @param  DefaultNotificationProcessor  $notificationProcessor
     * @param  LocalStorageService  $localStorageService
     */
    public function __construct(
        DefaultNotificationProcessor $notificationProcessor,
        LocalStorageService $localStorageService
    ) {
        $this->notificationProcessor = $notificationProcessor;
        $this->localStorageService = $localStorageService;
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
        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));
        $notification->setContent($this->getContent());
        $notification->setImageUrl($this->getFileUrl(config('memes.vince_carter_its_over_gif_url')));

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
