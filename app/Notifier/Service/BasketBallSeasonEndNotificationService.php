<?php

declare(strict_types=1);

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;
use Core\Storage\Service\LocalStorageService;

/**
 * Class BasketBallSeasonEndNotificationService
 * @package App\Notifier\Service
 */
class BasketBallSeasonEndNotificationService implements NotificationServiceInterface
{
    /**
     * @var LocalStorageService
     */
    private LocalStorageService $localStorageService;

    /**
     * BasketBallSeasonEndNotificationService constructor.
     * @param  LocalStorageService  $localStorageService
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

    /**
     * @return Notification
     */
    private function getNotification(): Notification
    {
        $notification = new Notification();
        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));
        $notification->setNotifier(config('sms.weather_for_basketball.sender_name'));
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
