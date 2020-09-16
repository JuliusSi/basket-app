<?php

namespace App\Notifier\Service;

use App\Notifier\Model\Notification;
use App\Service\WeatherForBasketBallWarningService;

/**
 * Class WeatherForBasketBallNotificationService
 * @package App\Notifier\Service
 */
class WeatherForBasketBallNotificationService
{
    /**
     * @var WeatherForBasketBallWarningService
     */
    private WeatherForBasketBallWarningService $weatherForBasketBallWarningService;

    /***
     * WeatherForBasketBallNotificationService constructor.
     * @param  WeatherForBasketBallWarningService  $weatherForBasketBallWarningService
     */
    public function __construct(WeatherForBasketBallWarningService $weatherForBasketBallWarningService)
    {
        $this->weatherForBasketBallWarningService = $weatherForBasketBallWarningService;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        $warnings = $this->weatherForBasketBallWarningService->getWarningMessages();
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
        $notification->setSmsRecipients(config('notification.sms_recipients'));

        return $notification;
    }

    /**
     * @param  string[]  $warnings
     * @return string
     */
    private function getBadWeatherMessage(array $warnings): string
    {
        $warningsMessage = implode(',', $warnings);

        return sprintf('%s: %s', __('weather-rules.error'), $warningsMessage);
    }
}
