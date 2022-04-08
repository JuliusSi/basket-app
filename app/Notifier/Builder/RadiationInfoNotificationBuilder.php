<?php

namespace App\Notifier\Builder;

use App\Notifier\Model\Notification;
use App\RadiationChecker\Model\RadiationInfo;
use App\RadiationChecker\Service\RadiationInfoService;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

/**
 * Class RadiationInfoNotificationService
 * @package App\Notifier\Service
 */
class RadiationInfoNotificationBuilder implements NotificationBuilder
{
    /**
     * @var RadiationInfoService
     */
    private RadiationInfoService $radiationInfoService;

    /**
     * @var Translator
     */
    private Translator $translator;

    /**
     * @var ConfigRepository
     */
    private ConfigRepository $configRepository;

    /**
     * RadiationInfoNotificationService constructor.
     * @param  RadiationInfoService  $radiationInfoService
     * @param  Translator  $translator
     * @param  ConfigRepository  $configRepository
     */
    public function __construct(
        RadiationInfoService $radiationInfoService,
        Translator $translator,
        ConfigRepository $configRepository
    ) {
        $this->radiationInfoService = $radiationInfoService;
        $this->translator = $translator;
        $this->configRepository = $configRepository;
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
        $notification->setNotifier($this->getConfigValue('sms.radiation.sender_name'));
        $notification->setSmsRecipients($this->getConfigValue('sms.radiation.recipients'));
        $notification->setContent($this->getContent($radiationInfo));

        return $notification;
    }

    /**
     * @param  RadiationInfo  $radiationInfo
     * @return string
     */
    private function getContent(RadiationInfo $radiationInfo): string
    {
        return $this->translator->get(
            'radiation.notification_high_radiation_background',
            [
                'radiationBackground' => $radiationInfo->getRadiationBackground(),
                'updatedAt' => $radiationInfo->getUpdatedAt(),
                'normalRadiationBackground' => $this->getConfigValue('radiation.radiation_background_normal'),
            ],
        );
    }

    /**
     * @param  string  $key
     * @return mixed
     */
    private function getConfigValue(string $key): mixed
    {
        return $this->configRepository->get($key);
    }
}
