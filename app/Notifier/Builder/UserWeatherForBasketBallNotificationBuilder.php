<?php

declare(strict_types=1);

namespace App\Notifier\Builder;

use App\Model\User;
use App\Model\UserAttribute;
use App\Notifier\Model\Notification;
use App\WeatherChecker\Builder\BadWeatherMessageBuilder;
use App\WeatherChecker\Builder\GoodWeatherMessageBuilder;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Response\WeatherResponse;
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
     * @throws Exception
     */
    public function getNotifications(): array
    {
        if (!$users = $this->getUsers()) {
            return [];
        }

        return $this->buildNotifications($users);
    }

    /**
     * @param  User[]  $users
     *
     * @return Notification[]
     * @throws Exception
     */
    private function buildNotifications(array $users): array
    {
        $notifications = [];

        foreach ($users as $user) {
            if (!$placeCode = $user->getUserAttributeValueByName(UserAttribute::NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_PLACE_CODE)) {
                continue;
            }

            if ($user->sms < 1) {
                Log::warning(sprintf('Trying to send sms to user %s but user SMS balance less than 1.', $user->username));

                $int = \random_int(1, 2);
                if ($int === 2) {
                    $this->createUserNotificationAboutSMSLimitError($user);
                }

                continue;
            }

            $response = $this->getWarningResponse($placeCode);
            if (null === $response) {
                continue;
            }

            Log::info(sprintf('Weather for basketball notification prepared for user: %s.', $user->username));
            $notifications[] = $this->resolveNotification($response, $user);
            $this->updateUserSmsBalance($user);
            $this->createUserNotification($user);
        }

        return $notifications;
    }

    private function updateUserSmsBalance(User $user): void
    {
        $user->update(['sms'=> --$user->sms]);
    }

    private function createUserNotificationAboutSMSLimitError(User $user): void
    {
        $user->userNotifications()->create([
            'name' => 'Negalime išsiųsti SMS apie orą krepšiniui',
            'description' => 'Nepakakankamas SMS balansas.',
        ]);
    }

    private function createUserNotification(User $user): void
    {
        $user->userNotifications()->create([
            'name' => 'SMS pranešimas apie orą krepšiniui suformuotas!',
            'description' => sprintf('Pranešame, kad suformavome SMS pranešimą apie orą krepšiniui ir jį išsiųsime netrukus numeriu: %s.', $user->phone)
            ]);
    }

    private function resolveNotification(WeatherResponse $response, User $user): Notification
    {
        if (!$response->getWarnings()) {
            return $this->buildNotification($this->getGoodWeatherMessage($response), $user);
        }

        return $this->buildNotification($this->getBadWeatherMessage($response), $user);
    }

    private function getGoodWeatherMessage(WeatherResponse $response): string
    {
        $startDate = now()->format('H:i');
        $endDate = $this->getCheckEndDateTime()->format('H:i');

        return $this->goodWeatherMessageBuilder->getMessage(
            $startDate,
            $endDate,
            $response->getMeasuredAt()->format('H:i')
        );
    }

    private function buildNotification(string $message, User $user): Notification
    {
        $notification = new Notification();
        $notification->setContent($message);
        $notification->setSmsRecipients([$user->getAttribute('phone')]);
        $notification->setNotifier(config('sms.weather_for_basketball.sender_name'));

        return $notification;
    }

    private function getBadWeatherMessage(WeatherResponse $response): string
    {
        return $this->badWeatherMessageBuilder->getMessage($response);
    }

    private function getWarningResponse(string $placeCode): ?WeatherResponse
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
    private function checkWeather(string $placeCode): WeatherResponse
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
        return User::with('userAttributes')->whereHas('userAttributes', static function (Builder $query) {
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
