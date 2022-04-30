<?php

declare(strict_types=1);

namespace Src\Sms\Model;

use DateTime;

class ESms
{
    public function __construct(
        private readonly string $sender,
        private readonly string $recipient,
        private readonly string $content,
        private readonly ?DateTime $dateWhenToSend = null,
        private readonly ?int $group = null,
        private readonly ?string $callbackLink = null,
    ) {
    }

    public static function create(
        string $sender,
        string $recipient,
        string $content,
        ?DateTime $dateWhenToSend = null,
        ?int $group = null,
        ?string $callbackLink = null,
    ): self {
        return new self($sender, $recipient, $content, $dateWhenToSend, $group, $callbackLink);
    }

    public function sender(): string
    {
        return $this->sender;
    }

    public function recipient(): string
    {
        return $this->recipient;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function whenToSend(): ?DateTime
    {
        return $this->dateWhenToSend;
    }

    public function group(): ?int
    {
        return $this->group;
    }

    public function callbackLink(): ?string
    {
        return $this->callbackLink;
    }
}
