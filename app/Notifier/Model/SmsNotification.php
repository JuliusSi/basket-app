<?php

declare(strict_types=1);

namespace App\Notifier\Model;

class SmsNotification
{
    public function __construct(private string $content, private array $recipients, private string $sender)
    {
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
