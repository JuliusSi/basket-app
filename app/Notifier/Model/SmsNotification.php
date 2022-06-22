<?php

declare(strict_types=1);

namespace App\Notifier\Model;

class SmsNotification
{
    public function __construct(
        private readonly string $content,
        private readonly array $recipients,
        private readonly string $sender,
    ) {
    }

    public static function create(string $content, array $recipients, string $sender): self
    {
        return new self($content, $recipients, $sender);
    }

    public function content(): string
    {
        return $this->content;
    }

    public function recipients(): array
    {
        return $this->recipients;
    }

    public function sender(): string
    {
        return $this->sender;
    }
}
