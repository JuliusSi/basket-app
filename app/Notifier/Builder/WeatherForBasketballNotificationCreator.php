<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Model\User;
use App\Notifier\Event\ChatNotificationCreated;
use App\Notifier\Event\FacebookNotificationCreated;
use App\Notifier\Event\SmsNotificationCreated;
use App\Notifier\Model\ChatNotification;
use App\Notifier\Model\FacebookNotification;
use App\Notifier\Model\SmsNotification;
use App\WeatherChecker\Builder\BadWeatherMessageBuilder;
use App\WeatherChecker\Builder\GoodWeatherMessageBuilder;
use App\WeatherChecker\Model\Response\WarningResponse;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class WeatherForBasketballNotificationCreator
{
    public function __construct(
        private readonly GoodWeatherMessageBuilder $goodWeatherMessageBuilder,
        private readonly BadWeatherMessageBuilder $badWeatherMessageBuilder,
    ) {
    }

    public function create(WarningResponse $response): void
    {
        if (!$response->getWarnings()) {
            $this->buildNotification(
                $this->getGoodWeatherMessage($response),
                $this->getRandomVideoUrl('videos.url.motivation_videos.weather_available_for_basketball'),
                $this->getGoodWeatherFacebookMessage($response)
            );

            return;
        }

        $this->buildNotification(
            $this->getBadWeatherMessage($response),
            $this->getRandomVideoUrl('videos.url.motivation_videos.weather_not_available_for_basketball'),
            $this->badWeatherMessageBuilder->getFacebookMessage($response)
        );
    }

    private function getRandomVideoUrl(string $configKey)
    {
        $videos = config($configKey);

        if (!$videos) {
            throw new InvalidArgumentException('No configuration for key: '.$configKey);
        }

        return Arr::random($videos);
    }

    private function getGoodWeatherMessage(WarningResponse $response): string
    {
        $startDate = $response->getCheckedFrom()->format('H:i');
        $endDate = $response->getCheckedTo()->format('H:i');

        return $this->goodWeatherMessageBuilder->getMessage($startDate, $endDate,
            $response->getMeasuredAt()->format('H:i'));
    }

    private function getGoodWeatherFacebookMessage(WarningResponse $response): string
    {
        $startDate = $response->getCheckedFrom()->format('H:i');
        $endDate = $response->getCheckedTo()->format('H:i');

        return $this->goodWeatherMessageBuilder->getFacebookMessage($startDate, $endDate,
            $response->getMeasuredAt()->format('H:i'));
    }

    private function buildNotification(string $message, string $link, string $fbMessage): void
    {
        if (!$link || !$message || !$fbMessage) {
            throw new InvalidArgumentException('Not provided link message or fb message.');
        }

        $fbNotification = FacebookNotification::create($fbMessage, $link);
        FacebookNotificationCreated::dispatch($fbNotification);

        $user = User::where('username', config('seeder.user.username'))->first();
        if ($user && \in_array(now()->dayOfWeekIso, [5, 6, 7], true)) {
            $chatNotification = ChatNotification::create($user, $message);
            ChatNotificationCreated::dispatch($chatNotification);
        }

        if ($this->canCreateSmsNotification()) {
            $smsNotification = SmsNotification::create(
                $message,
                config('sms.weather_for_basketball.recipients'),
                config('sms.weather_for_basketball.sender_name'));
            SmsNotificationCreated::dispatch($smsNotification);
        }
    }

    private function canCreateSmsNotification(): bool
    {
        $now = now();

        if (!\in_array($now->dayOfWeekIso, [5, 6, 7], true)) {
            return false;
        }

        if ($now->format('H') !== config('notification.weather_for_basketball.hour_to_notify')) {
            return false;
        }

        return true;
    }

    private function getBadWeatherMessage(WarningResponse $response): string
    {
        return $this->badWeatherMessageBuilder->getMessage($response);
    }
}
