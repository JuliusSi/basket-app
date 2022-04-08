<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Notifier\Model\FacebookNotification;
use App\Notifier\Model\Notification;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Core\Storage\Service\LocalStorageService;
use Exception;

class WeatherForBasketBallNotificationBuilder implements NotificationBuilder
{
    public function __construct(
        private WeatherCheckManager $weatherCheckManager,
        private LocalStorageService $localStorageService
    ) {
    }

    /**
     * @return Notification[]
     */
    public function getNotifications(): array
    {
        if (!$notification = $this->getNotification()) {
            return [];
        }

        return [$notification];
    }

    private function getNotification(): ?Notification
    {
        $weatherWarnings = $this->getWarnings();
        if (null === $weatherWarnings) {
            return null;
        }

        return $this->resolveNotification($weatherWarnings);
    }

    private function resolveNotification(array $warnings): ?Notification
    {
        if (!$warnings) {
            return $this->buildNotification(
                __('weather-rules.success'),
                $this->getFileUrl(config('memes.jr_smith_reaction_gif_url'))
            );
        }

        return $this->buildNotification(
            $this->getBadWeatherMessage($warnings),
            $this->getFileUrl(config('memes.lebron_james_what_reaction_gif_url'))
        );
    }

    /**
     * @return null|Warning[]
     */
    private function getWarnings(): ?array
    {
        try {
            return $this->checkWeather(config('notification.weather_for_basketball.place_code_to_check'));
        } catch (Exception $exception) {
            return null;
        }
    }

    private function buildNotification(string $message, ?string $imageUrl): ?Notification
    {
        if (!$imageUrl) {
            return null;
        }

        $notification = new Notification(new FacebookNotification($message, $imageUrl));
        $notification->setContent($message);
        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));
        $notification->setNotifier(config('sms.weather_for_basketball.sender_name'));

        return $notification;
    }

    /**
     * @param Warning[] $warnings
     */
    private function getBadWeatherMessage(array $warnings): string
    {
        $warningsMessage = implode(', ', $this->getTranslatedMessages($warnings));

        return sprintf('%s: %s', __('weather-rules.error'), $warningsMessage);
    }

    /**
     * @param Warning[] $warnings
     *
     * @return string[]
     */
    private function getTranslatedMessages(array $warnings): array
    {
        $translatedMessages = [];
        foreach ($warnings as $warning) {
            $translatedMessages[] = $warning->getTranslatedMessage();
        }

        return $translatedMessages;
    }

    /**
     * @throws Exception
     *
     * @return Warning[]
     */
    private function checkWeather(string $placeCode): array
    {
        $endDateTime = $this->getCheckEndDateTime();
        $startDateTime = Carbon::now()->toDateTimeString();

        return $this->weatherCheckManager->manage($placeCode, $startDateTime, $endDateTime);
    }

    private function getFileUrl(string $fileName): ?string
    {
        return $this->localStorageService->findFileUrl($fileName, LocalStorageService::DIRECTORY_MEMES);
    }

    private function getCheckEndDateTime(): string
    {
        return Carbon::now()->addHours(config('weather.rules.hours_to_check'))->toDateTimeString();
    }
}
