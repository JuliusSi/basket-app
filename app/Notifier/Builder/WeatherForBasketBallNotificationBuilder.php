<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Notifier\Model\FacebookNotification;
use App\Notifier\Model\Notification;
use App\WeatherChecker\Builder\BadWeatherMessageBuilder;
use App\WeatherChecker\Builder\GoodWeatherMessageBuilder;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Core\Storage\Service\LocalStorageService;
use Exception;
use Illuminate\Support\Facades\Log;

use function in_array;

class WeatherForBasketBallNotificationBuilder implements NotificationBuilder
{
    public function __construct(
        private WeatherCheckManager $weatherCheckManager,
        private LocalStorageService $localStorageService,
        private GoodWeatherMessageBuilder $goodWeatherMessageBuilder,
        private BadWeatherMessageBuilder $badWeatherMessageBuilder
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
                $this->getGoodWeatherMessage(),
                $this->getFileUrl(config('memes.jr_smith_reaction_gif_url'))
            );
        }

        return $this->buildNotification(
            $this->getBadWeatherMessage($warnings),
            $this->getFileUrl(config('memes.lebron_james_what_reaction_gif_url'))
        );
    }

    private function getGoodWeatherMessage(): string
    {
        $startDate = now()->format('m-d H:i');
        $endDate = $this->getCheckEndDateTime()->format('m-d H:i');

        return $this->goodWeatherMessageBuilder->getMessage($startDate, $endDate);
    }

    /**
     * @return null|Warning[]
     */
    private function getWarnings(): ?array
    {
        try {
            return $this->checkWeather(config('notification.weather_for_basketball.place_code_to_check'));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

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

    /**
     * @param Warning[] $warnings
     */
    private function getBadWeatherMessage(array $warnings): string
    {
        return $this->badWeatherMessageBuilder->getMessage($warnings);
    }

    /**
     * @throws Exception
     *
     * @return Warning[]
     */
    private function checkWeather(string $placeCode): array
    {
        $endDateTime = $this->getCheckEndDateTime()->toDateTimeString();
        $startDateTime = Carbon::now()->toDateTimeString();

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
