<?php

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;
use App\Service\SmsBatchSendService;

/**
 * Class WeatherForBasketBallSmsNotifier
 * @package App\Notifier\Collection
 */
class WeatherForBasketBallSmsNotifier implements NotifierInterface
{
    /**
     * @var SmsBatchSendService
     */
    private SmsBatchSendService $smsBatchSendService;

    /**
     * WeatherForBasketBallSmsNotifier constructor.
     * @param  SmsBatchSendService  $smsBatchSendService
     */
    public function __construct(SmsBatchSendService $smsBatchSendService)
    {
        $this->smsBatchSendService = $smsBatchSendService;
    }

    /**
     * @param  Notification[]  $notifications
     */
    public function notify(array $notifications): void
    {
        $this->smsBatchSendService->send($notifications);
    }
}
