<?php

declare(strict_types=1);

namespace App\Notifier\Model;

class FacebookNotification
{
    public function __construct(private readonly string $content, private readonly string $link)
    {
    }

    public static function create(string $content, string $link): self
    {
        return new self($content, $link);
    }

    public function content(): string
    {
        return $this->content;
    }

    public function link(): string
    {
        return $this->link;
    }
}
