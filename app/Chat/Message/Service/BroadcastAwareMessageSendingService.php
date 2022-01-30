<?php

declare(strict_types=1);

namespace App\Chat\Message\Service;

use App\Chat\Message\Logger\UserFirstTodayMessageLogger;
use App\Events\ChatMessageSent;
use App\Model\User;

class BroadcastAwareMessageSendingService implements MessageSendingServiceInterface
{
    public function __construct(private BaseMessageSendingService $baseMessageSendingService)
    {
    }

    public function send(User $user, string $message): void
    {
        $this->actionsBeforeSending($user, $message);
        $this->baseMessageSendingService->send($user, $message);
        $this->actionsAfterSending($user, $message);
    }

    private function actionsBeforeSending(User $user, string $message): void
    {
        ChatMessageSent::broadcast($user, $message)->toOthers();
    }

    private function actionsAfterSending(User $user, string $message): void
    {
        UserFirstTodayMessageLogger::log($user);
    }
}
