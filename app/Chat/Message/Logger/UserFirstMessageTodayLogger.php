<?php

declare(strict_types=1);

namespace App\Chat\Message\Logger;

use App\Model\User;
use Carbon\Carbon;
use Core\Logger\LogDispatcher;
use Core\Logger\Model\Log;

class UserFirstMessageTodayLogger
{
    public static function log(User $user): void
    {
        LogDispatcher::dispatch(self::getActionLog($user), self::needToLogAction($user));
    }

    private static function needToLogAction(User $user): bool
    {
        return 1 === $user->chatMessages()->whereDate('created_at', Carbon::today())->count();
    }

    private static function getActionLog(User $user): Log
    {
        $message = __(
            'main.logs.user_first_chat_message',
            [
                'username' => $user->getAttribute('username'),
            ]
        );

        return Log::create($message);
    }
}
