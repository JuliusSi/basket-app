<?php

declare(strict_types=1);

namespace App\Notifier\Listener;

use App\Notifier\Builder\WeatherForBasketballNotificationCreator;
use App\WeatherChecker\Event\WeatherForBasketballChecked;
use App\WeatherChecker\Model\Response\WarningResponse;

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

    private function createNotifications(WarningResponse $response): void
    {
        $this->creator->create($response);
    }
}
