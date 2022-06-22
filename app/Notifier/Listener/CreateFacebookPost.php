<?php

declare(strict_types=1);

namespace App\Notifier\Listener;

use App\Notifier\Event\FacebookNotificationCreated;
use App\Notifier\Model\FacebookNotification;
use Src\Facebook\Client\Request\FacebookLinkPostRequestBody;
use Src\Facebook\Job\PostFacebookLink;

class CreateFacebookPost
{
    public function __invoke(FacebookNotificationCreated $notificationCreated): void
    {
        $this->notify($notificationCreated);
    }

    private function notify(FacebookNotificationCreated $notificationCreated): void
    {
        $this->postLink($this->buildRequest($notificationCreated->notification));
    }

    private function buildRequest(FacebookNotification $notification): FacebookLinkPostRequestBody
    {
        $request = new FacebookLinkPostRequestBody();
        $request->setLink($notification->link());
        $request->setMessage($notification->content());

        return $request;
    }

    private function postLink(FacebookLinkPostRequestBody $request): void
    {
        PostFacebookLink::dispatch($request);
    }
}
