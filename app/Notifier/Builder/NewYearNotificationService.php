<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Notifier\Model\FacebookNotification;
use App\Notifier\Model\Notification;
use Core\Storage\Service\LocalStorageService;

/**
 * Class NewYearNotificationService.
 */
class NewYearNotificationService implements NotificationBuilder
{
    private LocalStorageService $localStorageService;

    /**
     * NewYearNotificationService constructor.
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
        $notification = $this->buildNotification();
        if (!$notification) {
            return [];
        }

        return [$notification];
    }

    private function getContent(): string
    {
        $startNotify = config('notification.weather_for_basketball.start_notify');

        return __(
            'notification.new_year_greeting',
            ['startDate' => $startNotify]
        );
    }

    private function buildNotification(): Notification
    {
        $content = $this->getContent();
        $facebookNotification = new FacebookNotification($content, $this->getImageUrl());

        $notification = new Notification($facebookNotification);
        $notification->setContent($this->getContent());
        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));
        $notification->setNotifier(config('sms.weather_for_basketball.sender_name'));

        return $notification;
    }

    private function getImageUrl(): ?string
    {
        return $this->getFileUrl(config('holidays.new_years'));
    }

    private function getFileUrl(string $fileName): ?string
    {
        return $this->localStorageService->findFileUrl($fileName, LocalStorageService::DIRECTORY_RANDOM);
    }
}
