<?php

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;
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
     * WeatherForBasketBallNotificationService constructor.
     * @param  WeatherCheckManager  $weatherCheckManager
     */
    public function __construct(WeatherCheckManager $weatherCheckManager)
    {
        $this->weatherCheckManager = $weatherCheckManager;
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
        $warnings = $this->checkWeather();
        if (!$warnings) {
            return $this->buildNotification(
                __('weather-rules.success'),
                config('memes.jr_smith_reaction_gif_url')
            );
        }

        return $this->buildNotification(
            $this->getBadWeatherMessage($warnings),
            config('memes.lebron_james_what_reaction_gif_url')
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
        $notification->setSmsRecipients(config('notification.weather_for_basketball.sms_recipients'));

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
            $translatedMessages = $warning->getTranslatedMessage();
        }

        return $translatedMessages;
    }

    /**
     * @return Warning[]
     */
    private function checkWeather(): array
    {
        return $this->weatherCheckManager->manage();
    }
}
