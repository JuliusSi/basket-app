<?php

declare(strict_types=1);

namespace App\Chat\Message\Service;

use App\Chat\Job\SendMessage;
use App\Model\User;

class SendQueuedMessageService implements SendMessageServiceInterface
{
    public function send(User $user, string $message): void
    {
        SendMessage::dispatch($user, $message);
    }
}
