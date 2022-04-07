<?php

declare(strict_types=1);

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;
use Core\Storage\Service\LocalStorageService;

/**
 * Class NewYearNotificationService.
 */
class NewYearNotificationService implements NotificationServiceInterface
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
        $notification = new Notification();
        $notification->setContent($this->getContent());
        $notification->setImageUrl($this->getImageUrl());
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
