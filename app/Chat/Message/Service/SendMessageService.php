<?php

declare(strict_types=1);

namespace App\Chat\Message\Service;

use App\Model\User;
use Illuminate\Support\Collection;

class SendMessageService implements SendMessageServiceInterface
{
    public function __construct(private readonly Collection $modifierCollection)
    {
    }

    public function send(User $user, string $message): void
    {
        $this->saveMessage($user, $this->modifyMessage($user, $message));
    }

    private function saveMessage(User $user, string $message): void
    {
        $user->chatMessages()->create([
            'message' => $message,
        ]);
    }

    private function modifyMessage(User $user, string $message): string
    {
        foreach ($this->modifierCollection->all() as $modifier) {
            $message = $modifier->modify($message, $user);
        }

        return $message;
    }
}
