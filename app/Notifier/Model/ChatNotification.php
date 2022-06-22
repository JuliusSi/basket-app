<?php

declare(strict_types=1);

namespace App\Notifier\Model;

use App\Model\User;

class ChatNotification
{
    public function __construct(
        private readonly User $sender,
        private readonly string $message,
    ) {
    }

    public static function create(User $sender, string $message): self
    {
        return new self($sender, $message);
    }

    public function sender(): User
    {
        return $this->sender;
    }

    public function message(): string
    {
        return $this->message;
    }
}
