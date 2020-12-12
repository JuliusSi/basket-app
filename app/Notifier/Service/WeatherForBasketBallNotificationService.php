<?php

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;
use Core\Storage\Service\LocalStorageService;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;

/**
 * Class WeatherForBasketBallNotificationService
 * @package App\Notifier\Service
 */
class WeatherForBasketBallNotificationService
{
    /**
     * @var WeatherCheckManager
     */
    private WeatherCheckManager $weatherCheckManager;

    /**
     * @var LocalStorageService
     */
    private LocalStorageService $localStorageService;

    /**
     * WeatherForBasketBallNotificationService constructor.
     * @param  WeatherCheckManager  $weatherCheckManager
     * @param  LocalStorageService  $localStorageService
     */
    public function __construct(WeatherCheckManager $weatherCheckManager, LocalStorageService $localStorageService)
    {
        $this->weatherCheckManager = $weatherCheckManager;
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
        $warnings = $this->checkWeather(config('notification.weather_for_basketball.place_code_to_check'));
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
     * @param  string  $message
     * @param  string|null  $imageUrl
     * @return Notification
     */
    private function buildNotification(string $message, ?string $imageUrl): Notification
    {
        $notification = new Notification();
        $notification->setContent($message);
        $notification->setImageUrl($imageUrl);
        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));

        return $notification;
    }

    /**
     * @param  Warning[]  $warnings
     * @return string
     */
    private function getBadWeatherMessage(array $warnings): string
    {
        $warningsMessage = implode(', ', $this->getTranslatedMessages($warnings));

        return sprintf('%s: %s', __('weather-rules.error'), $warningsMessage);
    }

    /**
     * @param  Warning[]  $warnings
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
     * @param  string  $placeCode
     * @return Warning[]
     */
    private function checkWeather(string $placeCode): array
    {
        return $this->weatherCheckManager->manage($placeCode);
    }

    /**
     * @param  string  $fileName
     * @return string|null
     */
    private function getFileUrl(string $fileName): ?string
    {
        return $this->localStorageService->findFileUrl($fileName, LocalStorageService::MEMES_DIRECTORY);
    }
}
