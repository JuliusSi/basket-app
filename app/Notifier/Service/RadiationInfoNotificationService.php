<?php

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;
use App\RadiationChecker\Model\RadiationInfo;
use App\RadiationChecker\Service\RadiationInfoService;

/**
 * Class RadiationInfoNotificationService
 * @package App\Notifier\Service
 */
class RadiationInfoNotificationService implements NotificationServiceInterface
{
    /**
     * @var RadiationInfoService
     */
    private RadiationInfoService $radiationInfoService;

    /**
     * RadiationInfoNotificationService constructor.
     * @param  RadiationInfoService  $radiationInfoService
     */
    public function __construct(RadiationInfoService $radiationInfoService)
    {
        $this->radiationInfoService = $radiationInfoService;
    }

    /**
     * @return Notification[]
     */
    public function getNotifications(): array
    {
        $radiationInfo = $this->radiationInfoService->getRadiationInfo();
        if (!$radiationInfo || !$radiationInfo->isRiskyStatus()) {
            return [];
        }

        return [$this->buildNotification($radiationInfo)];
    }

    /**
     * @param  RadiationInfo  $radiationInfo
     * @return Notification
     */
    private function buildNotification(RadiationInfo $radiationInfo): Notification
    {
        $notification = new Notification();
        $notification->setNotifier(config('sms.radiation.sender_name'));
        $notification->setSmsRecipients(config('sms.radiation.recipients'));
        $notification->setContent($this->getContent($radiationInfo));

        return $notification;
    }

    /**
     * @param  RadiationInfo  $radiationInfo
     * @return string
     */
    private function getContent(RadiationInfo $radiationInfo): string
    {
        return __(
            'radiation.notification_high_radiation_background',
            [
                'radiationBackground' => $radiationInfo->getRadiationBackground(),
                'updatedAt' => $radiationInfo->getUpdatedAt(),
                'normalRadiationBackground' => config('radiation.radiation_background_normal'),
            ],
        );
    }
}
