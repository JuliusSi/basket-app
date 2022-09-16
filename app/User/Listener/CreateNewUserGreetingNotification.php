<?php

declare(strict_types=1);

namespace App\User\Listener;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateNewUserGreetingNotification implements ShouldQueue
{
    public function __invoke(Registered $registered): void
    {
        $this->createNotification($registered);
    }

    private function createNotification(Registered $registered): void
    {
        $user = $registered->user;

        $user->userNotifications()->create([
            'name' => 'Sveikiname prisijungus prie KrepsinisLauke.LT!',
            'description' => 'Naujiems varototojams, norintiems gauti SMS pranešimus apie orą krepšiniui, prašome nueiti į nustatymus ir užpildyti telefono numerį.
            Malonaus naršymo mūsu svetainėje!',
        ]);
    }
}
