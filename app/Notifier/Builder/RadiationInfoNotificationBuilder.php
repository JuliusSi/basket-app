<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Notifier\Model\Notification;
use App\RadiationChecker\Model\RadiationInfo;
use App\RadiationChecker\Service\RadiationInfoService;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Translation\Translator;

class RadiationInfoNotificationBuilder implements NotificationBuilder
{
    public function __construct(
        private  readonly RadiationInfoService $radiationInfoService,
        private  readonly Translator $translator,
        private  readonly ConfigRepository $configRepository
    ) {
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

    private function buildNotification(RadiationInfo $radiationInfo): Notification
    {
        $notification = new Notification();
        $notification->setNotifier($this->getConfigValue('sms.radiation.sender_name'));
        $notification->setSmsRecipients($this->getConfigValue('sms.radiation.recipients'));
        $notification->setContent($this->getContent($radiationInfo));

        return $notification;
    }

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

    private function getConfigValue(string $key): mixed
    {
        return $this->configRepository->get($key);
    }
}
