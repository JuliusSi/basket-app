<?php

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;
use App\Service\FacebookLinkPostService;

/**
 * Class WeatherForBasketBallFacebookPageNotifier
 * @package App\Notifier\Collection
 */
class WeatherForBasketBallFacebookPageNotifier implements NotifierInterface
{
    /**
     * @var FacebookLinkPostService
     */
    private FacebookLinkPostService $facebookLinkPostService;

    public function __construct(FacebookLinkPostService $facebookLinkPostService)
    {
        $this->facebookLinkPostService = $facebookLinkPostService;
    }

    /**
     * @param  Notification[]  $notifications
     */
    public function notify(array $notifications): void
    {
        $this->facebookLinkPostService->post($notifications);
    }
}
