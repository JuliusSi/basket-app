<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Model\User;
use App\Notifier\Model\Notification;

/**
 * Class ChatNotifier
 * @package App\Notifier\Collection
 */
class ChatNotifier implements NotifierInterface
{
    /**
     * @param  Notification[]  $notifications
     */
    public function notify(array $notifications): void
    {
        $user = User::where('username', config('seeder.user.username'))->first();
        if (!$user) {
            return;
        }

        $this->saveMessages($notifications, $user);
    }

    /**
     * @param  Notification[]  $notifications
     * @param  User  $user
     */
    private function saveMessages(array $notifications, User $user): void
    {
        foreach ($notifications as $notification) {
            $this->saveMessage($notification, $user);
        }
    }

    /**
     * @param  Notification  $notification
     * @param  User  $user
     */
    private function saveMessage(Notification $notification, User $user): void
    {
        $user->chatMessages()->create([
            'message' => $notification->getContent(),
        ]);
    }
}
