<?php

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;
use Core\Storage\Service\LocalStorageService;

/**
 * Class NewYearNotificationService
 * @package App\Notifier\Service
 */
class NewYearNotificationService implements NotificationServiceInterface
{
    /**
     * @var LocalStorageService
     */
    private LocalStorageService $localStorageService;

    /**
     * NewYearNotificationService constructor.
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
        $notification = $this->buildNotification();
        if (!$notification) {
            return [];
        }

        return [$notification];
    }

    /**
     * @return string
     */
    private function getContent(): string
    {
        $startNotify = config('notification.weather_for_basketball.start_notify');

        return __(
            'notification.new_year_greeting',
            ['startDate' => $startNotify]
        );
    }

    /**
     * @return Notification
     */
    private function buildNotification(): Notification
    {
        $notification = new Notification();
        $notification->setContent($this->getContent());
        $notification->setImageUrl($this->getImageUrl());
        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));

        return $notification;
    }

    /**
     * @return string|null
     */
    private function getImageUrl(): ?string
    {
        return $this->getFileUrl(config('holidays.new_years'));
    }

    /**
     * @param  string  $fileName
     * @return string|null
     */
    private function getFileUrl(string $fileName): ?string
    {
        return $this->localStorageService->findFileUrl($fileName, LocalStorageService::DIRECTORY_RANDOM);
    }
}
