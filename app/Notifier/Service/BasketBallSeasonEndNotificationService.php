<?php

declare(strict_types=1);

namespace App\Notifier\Service;

use App\Notifier\Model\FacebookNotification;
use App\Notifier\Model\Notification;
use Core\Storage\Service\LocalStorageService;

class BasketBallSeasonEndNotificationService implements NotificationServiceInterface
{
    public function __construct(private LocalStorageService $localStorageService)
    {
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
        $content = $this->getContent();
        $facebookNotification = new FacebookNotification(
            $content,
            $this->getFileUrl(config('memes.vince_carter_its_over_gif_url'))
        );
        $notification = new Notification($facebookNotification);
        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));
        $notification->setNotifier(config('sms.weather_for_basketball.sender_name'));
        $notification->setContent($this->getContent());

        return $notification;
    }

    private function getContent(): string
    {
        $startNotify = config('notification.weather_for_basketball.start_notify');
        $endNotify = config('notification.weather_for_basketball.end_notify');

        return __('notification.basketball_season_end', ['endDate' => $endNotify, 'startDate' => $startNotify]);
    }

    private function getFileUrl(string $fileName, string $directory = LocalStorageService::DIRECTORY_MEMES): ?string
    {
        return $this->localStorageService->findFileUrl($fileName, $directory);
    }
}
