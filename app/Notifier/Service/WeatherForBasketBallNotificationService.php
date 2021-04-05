<?php

declare(strict_types=1);

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;
use Carbon\Carbon;
use Core\Storage\Service\LocalStorageService;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;

/**
 * Class WeatherForBasketBallNotificationService
 * @package App\Notifier\Service
 */
class WeatherForBasketBallNotificationService implements NotificationServiceInterface
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
        $notification->setNotifier(config('sms.weather_for_basketball.sender_name'));

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
        $endDateTime = $this->getCheckEndDateTime();
        $startDateTime = Carbon::now()->toDateTimeString();

        return $this->weatherCheckManager->manage($placeCode, $startDateTime, $endDateTime);
    }

    /**
     * @param  string  $fileName
     * @return string|null
     */
    private function getFileUrl(string $fileName): ?string
    {
        return $this->localStorageService->findFileUrl($fileName, LocalStorageService::DIRECTORY_MEMES);
    }

    /**
     * @return string
     */
    private function getCheckEndDateTime(): string
    {
        return Carbon::now()->addHours(config('weather.rules.hours_to_check'))->toDateTimeString();
    }
}
