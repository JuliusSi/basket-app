<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Model\User;
use App\Model\UserAttribute;
use App\Notifier\Model\Notification;
use App\WeatherChecker\Builder\BadWeatherMessageBuilder;
use App\WeatherChecker\Builder\GoodWeatherMessageBuilder;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Response\WarningResponse;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class UserWeatherForBasketBallNotificationBuilder implements NotificationBuilder
{
    public function __construct(
        private readonly WeatherCheckManager $weatherCheckManager,
        private readonly GoodWeatherMessageBuilder $goodWeatherMessageBuilder,
        private readonly BadWeatherMessageBuilder $badWeatherMessageBuilder
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
            $response = $this->getWarningResponse($placeCode);
            if (null === $response) {
                continue;
            }

            $notifications[] = $this->resolveNotification($response, $user);
        }

        return $notifications;
    }

    private function resolveNotification(WarningResponse $response, User $user): Notification
    {
        if (!$response->getWarnings()) {
            return $this->buildNotification($this->getGoodWeatherMessage(), $user);
        }

        return $this->buildNotification($this->getBadWeatherMessage($response), $user);
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

    private function getBadWeatherMessage(WarningResponse $response): string
    {
        return $this->badWeatherMessageBuilder->getMessage($response);
    }

    private function getWarningResponse(string $placeCode): ?WarningResponse
    {
        try {
            return $this->checkWeather($placeCode);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return null;
        }
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
