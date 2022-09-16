<?php

declare(strict_types=1);

namespace App\Notifier\Listener;

use App\Notifier\Builder\WeatherForBasketballNotificationCreator;
use App\WeatherChecker\Event\WeatherForBasketballChecked;
use App\WeatherChecker\Model\Response\WeatherResponse;

class NotifyAboutWeatherForBasketball
{
    public function __construct(
        private readonly WeatherForBasketballNotificationCreator $creator,
    ) {
    }

    public function __invoke(WeatherForBasketballChecked $weatherChecked): void
    {
        $this->createNotifications($weatherChecked->response);
    }

    private function createNotifications(WeatherResponse $response): void
    {
        logs()->info('Notifications creation about weather for basketball initiated.');

        $this->creator->create($response);
    }
}
