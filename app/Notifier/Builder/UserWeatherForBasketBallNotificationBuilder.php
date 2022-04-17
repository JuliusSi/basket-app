<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Model\User;
use App\Model\UserAttribute;
use App\Notifier\Model\Notification;
use App\WeatherChecker\Builder\BadWeatherMessageBuilder;
use App\WeatherChecker\Builder\GoodWeatherMessageBuilder;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UserWeatherForBasketBallNotificationBuilder implements NotificationBuilder
{
    public function __construct(
        private WeatherCheckManager $weatherCheckManager,
        private GoodWeatherMessageBuilder $goodWeatherMessageBuilder,
        private BadWeatherMessageBuilder $badWeatherMessageBuilder
    ) {
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
            return $this->buildNotification($this->getGoodWeatherMessage(), $user);
        }

        return $this->buildNotification($this->getBadWeatherMessage($warnings), $user);
    }

    private function getGoodWeatherMessage(): string
    {
        $startDate = now()->format('H:i');
        $endDate = $this->getCheckEndDateTime()->format('H:i');

        return $this->goodWeatherMessageBuilder->getMessage($startDate, $endDate);
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
        return $this->badWeatherMessageBuilder->getMessage($warnings);
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
        $endDateTime = $this->getCheckEndDateTime()->toDateTimeString();
        $startDateTime = now()->toDateTimeString();

        return $this->weatherCheckManager->manage($placeCode, $startDateTime, $endDateTime);
    }

    private function getCheckEndDateTime(): Carbon
    {
        return now()->addHours(config('weather.rules.hours_to_check'));
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
