<?php

declare(strict_types=1);

namespace App\User\Listener;

use Illuminate\Auth\Events\Login;

class UpdateLastLoginAt
{
    public function __invoke(Login $login): void
    {
        $this->updateUser($login);
    }

    private function updateUser(Login $authenticated): void
    {
        $user = $authenticated->user;

        $user->update([
            'last_login_at' => now()->toDateTimeString(),
        ]);
    }
}
