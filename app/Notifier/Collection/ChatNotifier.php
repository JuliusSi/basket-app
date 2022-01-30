<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Chat\Message\Service\BaseMessageSendingService;
use App\Model\User;
use App\Notifier\Model\Notification;

class ChatNotifier implements NotifierInterface
{
    public function __construct(private BaseMessageSendingService $messageSendService)
    {
    }

    /**
     * @param  Notification[]  $notifications
     */
    public function notify(array $notifications): void
    {
        $user = User::where('username', config('seeder.user.username'))->first();
        if (!$user) {
            return;
        }

        $this->sendChatMessages($notifications, $user);
    }

    /**
     * @param  Notification[]  $notifications
     * @param  User  $user
     */
    private function sendChatMessages(array $notifications, User $user): void
    {
        foreach ($notifications as $notification) {
            $this->sendChatMessage($notification, $user);
        }
    }

    /**
     * @param  Notification  $notification
     * @param  User  $user
     */
    private function sendChatMessage(Notification $notification, User $user): void
    {
        $this->messageSendService->send($user, $notification->getContent());
    }
}
