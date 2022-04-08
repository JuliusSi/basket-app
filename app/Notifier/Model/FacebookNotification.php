<?php

declare(strict_types=1);

namespace App\Notifier\Model;

class FacebookNotification
{
    public function __construct(private string $content, private string $imageUrl)
    {
    }

    public function content(): string
    {
        return $this->content;
    }

    public function imageUrl(): string
    {
        return $this->imageUrl;
    }
}
