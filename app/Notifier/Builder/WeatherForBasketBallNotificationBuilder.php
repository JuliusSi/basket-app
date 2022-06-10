<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Notifier\Model\FacebookNotification;
use App\Notifier\Model\Notification;
use App\WeatherChecker\Builder\BadWeatherMessageBuilder;
use App\WeatherChecker\Builder\GoodWeatherMessageBuilder;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Response\WarningResponse;
use Carbon\Carbon;
use Core\Storage\Service\LocalStorageService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

use function in_array;

class WeatherForBasketBallNotificationBuilder implements NotificationBuilder
{
    public function __construct(
        private readonly WeatherCheckManager $weatherCheckManager,
        private readonly LocalStorageService $localStorageService,
        private readonly GoodWeatherMessageBuilder $goodWeatherMessageBuilder,
        private readonly BadWeatherMessageBuilder $badWeatherMessageBuilder
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
        $response = $this->getWarningResponse();
        if (null === $response) {
            return null;
        }

        return $this->resolveNotification($response);
    }

    private function resolveNotification(WarningResponse $response): ?Notification
    {
        if (!$response->getWarnings()) {
            return $this->buildNotification(
                $this->getGoodWeatherMessage($response),
                $this->getRandomVideoUrl(),
            );
        }

        return $this->buildNotification(
            $this->getBadWeatherMessage($response),
            $this->getFileUrl(config('memes.lebron_james_what_reaction_gif_url')),
        );
    }

    private function getRandomVideoUrl()
    {
        $videos = config('videos.url.motivation_videos.weather_available_for_basketball');

        return Arr::random($videos);
    }

    private function getGoodWeatherMessage(WarningResponse $response): string
    {
        $startDate = now()->format('H:i');
        $endDate = $this->getCheckEndDateTime()->format('H:i');

        return $this->goodWeatherMessageBuilder->getMessage($startDate, $endDate, $response->getUpdatedAt());
    }

    private function getWarningResponse(): ?WarningResponse
    {
        try {
            return $this->checkWeather(config('notification.weather_for_basketball.place_code_to_check'));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return null;
        }
    }

    private function buildNotification(string $message, ?string $link): ?Notification
    {
        if (!$link) {
            return null;
        }

        $notification = new Notification(FacebookNotification::create($message, $link));
        $notification->setContent($message);
        $notification->setNotifier(config('sms.weather_for_basketball.sender_name'));
        $this->setSmsRecipientIfNeeded($notification);

        return $notification;
    }

    private function setSmsRecipientIfNeeded(Notification $notification): void
    {
        $now = now();

        if (!in_array($now->dayOfWeekIso, [5, 6, 7], true)) {
            return;
        }

        if ($now->format('H') !== config('notification.weather_for_basketball.hour_to_notify')) {
            return;
        }

        $notification->setSmsRecipients(config('sms.weather_for_basketball.recipients'));
    }

    private function getBadWeatherMessage(WarningResponse $response): string
    {
        return $this->badWeatherMessageBuilder->getMessage($response);
    }

    /**
     * @throws Exception
     */
    private function checkWeather(string $placeCode): WarningResponse
    {
        $endDateTime = $this->getCheckEndDateTime()->toDateTimeString();
        $startDateTime = now()->toDateTimeString();

        return $this->weatherCheckManager->manage($placeCode, $startDateTime, $endDateTime);
    }

    private function getFileUrl(string $fileName): ?string
    {
        return $this->localStorageService->findFileUrl($fileName, LocalStorageService::DIRECTORY_MEMES);
    }

    private function getCheckEndDateTime(): Carbon
    {
        return now()->addHours(config('weather.rules.hours_to_check'));
    }
}
