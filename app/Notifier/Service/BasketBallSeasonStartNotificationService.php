<?php

declare(strict_types=1);

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;
use Core\Storage\Service\LocalStorageService;

/**
 * Class BasketBallSeasonStartNotificationService.
 */
class BasketBallSeasonStartNotificationService implements NotificationServiceInterface
{
    private LocalStorageService $localStorageService;

    /**
     * BasketBallSeasonStartNotificationService constructor.
     */
    public function __construct(LocalStorageService $localStorageService)
    {
        $this->localStorageService = $localStorageService;
    }

    /**
     * @return Notification[]
     */
    public function getNotifications(): array
    {
        return [$this->getNotification()];
    }

    private function getNotification(): Notification
    {
        $notification = new Notification();
        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));
        $notification->setNotifier(config('sms.weather_for_basketball.sender_name'));
        $notification->setContent($this->getContent());
        $notification->setImageUrl($this->getFileUrl(config('memes.kyrie_irving_air_guitar_gif_url')));

        return $notification;
    }

    private function getContent(): string
    {
        $startNotify = config('notification.weather_for_basketball.start_notify');
        $notificationTime = config('notification.weather_for_basketball.time_to_notify');

        return __(
            'notification.basketball_season_start',
            ['startDate' => $startNotify, 'notificationTime' => $notificationTime]
        );
    }

    private function getFileUrl(string $fileName, string $directory = LocalStorageService::DIRECTORY_MEMES): ?string
    {
        return $this->localStorageService->findFileUrl($fileName, $directory);
    }
}
