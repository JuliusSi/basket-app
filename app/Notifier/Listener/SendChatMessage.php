<?php

declare(strict_types=1);

namespace App\Notifier\Listener;

use App\Chat\Message\Service\MessageSender;
use App\Notifier\Event\ChatNotificationCreated;
use App\Notifier\Model\ChatNotification;

class SendChatMessage
{
    public function __construct(private readonly MessageSender $sender)
    {
    }

    public function __invoke(ChatNotificationCreated $notificationCreated): void
    {
        $this->sendMessage($notificationCreated->notification);
    }

    private function sendMessage(ChatNotification $notification): void
    {
        $this->sender->send($notification->sender(), $notification->message());
    }
}
