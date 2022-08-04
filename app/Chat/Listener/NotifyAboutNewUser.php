<?php

declare(strict_types=1);

namespace App\Chat\Listener;

use App\Chat\Message\Service\MessageSender;
use App\Model\User;
use Illuminate\Auth\Events\Registered;

class NotifyAboutNewUser
{
    public function __construct(private readonly MessageSender $sender)
    {
    }

    public function __invoke(Registered $registered): void
    {
        $this->sendMessage($registered);
    }

    private function sendMessage(Registered $registered): void
    {
        $user = $this->getUser($registered);
        $message = __('main.new_user_registered', ['username' => $user->username]);
        $sender = $this->getSender();

        $this->sender->send($sender, $message);
    }

    private function getSender(): User
    {
        return User::where('username', config('seeder.user.username'))->first();
    }

    private function getUser(Registered $registered): User
    {
        /** @var User $user */
        $user = $registered->user;

        return $user;
    }
}
