<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Notifier\Model\FacebookNotification;
use App\Notifier\Model\Notification;
use Src\Facebook\Client\Request\FacebookLinkPostRequestBody;
use Src\Facebook\Job\PostFacebookLink;

class FacebookPageNotifier implements NotifierInterface
{
    /**
     * @param Notification[] $notifications
     */
    public function notify(array $notifications): void
    {
        foreach ($notifications as $notification) {
            if ($facebookNotification = $notification->facebookNotification()) {
                $this->postLink($this->buildRequest($facebookNotification));
            }
        }
    }

    private function buildRequest(FacebookNotification $notification): FacebookLinkPostRequestBody
    {
        $request = new FacebookLinkPostRequestBody();
        $request->setLink($notification->imageUrl());
        $request->setMessage($notification->content());

        return $request;
    }

    private function postLink(FacebookLinkPostRequestBody $request): void
    {
        PostFacebookLink::dispatch($request);
    }
}
