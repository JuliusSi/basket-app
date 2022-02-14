<?php

declare(strict_types=1);

namespace App\Notifier\Service;

use App\Model\User;
use App\Model\UserAttribute;
use App\Notifier\Model\Notification;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UserWeatherForBasketBallNotificationService implements NotificationServiceInterface
{
    public function __construct(private WeatherCheckManager $weatherCheckManager)
    {
    }

    /**
     * @return Notification[]
     */
    public function getNotifications(): array
    {
        if (!$users = $this->getUsers()) {
            return [];
        }

        return $this->buildNotifications($users);
    }

    /**
     * @param User[] $users
     *
     * @return Notification[]
     */
    private function buildNotifications(array $users): array
    {
        $notifications = [];
        foreach ($users as $user) {
            if (!$placeCode = $user->getUserAttributeValueByName(UserAttribute::NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_PLACE_CODE)) {
                continue;
            }
            $weatherWarnings = $this->getWarnings($placeCode);
            if (null === $weatherWarnings) {
                continue;
            }

            $notifications[] = $this->resolveNotification($weatherWarnings, $user);
        }

        return $notifications;
    }

    private function resolveNotification(array $warnings, User $user): Notification
    {
        if (!$warnings) {
            return $this->buildNotification(__('weather-rules.success'), $user);
        }

        return $this->buildNotification($this->getBadWeatherMessage($warnings), $user);
    }

    private function buildNotification(string $message, User $user): Notification
    {
        $notification = new Notification();
        $notification->setContent($message);
        $notification->setSmsRecipients([$user->getAttribute('phone')]);
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
     * @return null|Warning[]
     */
    private function getWarnings(string $placeCode): ?array
    {
        try {
            return $this->checkWeather($placeCode);
        } catch (Exception $exception) {
            return null;
        }
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

    private function getCheckEndDateTime(): string
    {
        return Carbon::now()->addHours(config('weather.rules.hours_to_check'))->toDateTimeString();
    }

    /**
     * @return User[]
     */
    private function getUsers(): array
    {
        return User::whereHas('userAttributes', static function (Builder $query) {
            $query
                ->where('name', UserAttribute::NAME_NOTIFY_ABOUT_WEATHER_FOR_BASKETBALL)
                ->where('value', UserAttribute::VALUE_TRUE)
            ;
        })->whereHas('userAttributes', static function (Builder $query) {
            $query
                ->where('name', UserAttribute::NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_TIME)
                ->where('value', now()->toTimeString('minute'))
                ->whereDate('updated_at', '<>', today())
            ;
        })->whereNotNull('phone')->get()->all();
    }
}
