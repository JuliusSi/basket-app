<?php

declare(strict_types=1);

namespace App\Chat\Message\Service;

use App\Events\ChatMessageSent;
use App\Model\User;
use Carbon\Carbon;
use Core\Logger\LogDispatcher;
use Core\Logger\Model\Log;

class BroadcastAwareMessageSendingService implements MessageSendingServiceInterface
{
    public function __construct(private BaseMessageSendingService $baseMessageSendingService)
    {
    }

    public function send(User $user, string $message): void
    {
        ChatMessageSent::broadcast($user, $message)->toOthers();

        $this->baseMessageSendingService->send($user, $message);
        $this->logActionIfNeeded($user);
    }

    private function logActionIfNeeded(User $user): void
    {
        if ($this->getUserTodayMessagesCount($user) > 1) {
            return;
        }

        LogDispatcher::dispatch($this->getActionLog($user));
    }

    private function getUserTodayMessagesCount(User $user): int
    {
        return $user->chatMessages()->whereDate('created_at', Carbon::today())->count();
    }

    private function getActionLog(User $user): Log
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
