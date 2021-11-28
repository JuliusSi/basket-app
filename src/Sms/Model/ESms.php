<?php

declare(strict_types=1);

namespace Src\Sms\Model;

use DateTime;

class ESms
{
    private string $sender;

    private string $recipient;

    private string $content;

    private ?DateTime $dateWhenToSend = null;

    private ?int $group = null;

    private ?string $callbackLink = null;

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @param  string  $sender
     */
    public function setSender(string $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @param  string  $recipient
     */
    public function setRecipient(string $recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param  string  $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return DateTime|null
     */
    public function getDateWhenToSend(): ?DateTime
    {
        return $this->dateWhenToSend;
    }

    /**
     * @param  DateTime|null  $dateWhenToSend
     */
    public function setDateWhenToSend(?DateTime $dateWhenToSend): void
    {
        $this->dateWhenToSend = $dateWhenToSend;
    }

    /**
     * @return int|null
     */
    public function getGroup(): ?int
    {
        return $this->group;
    }

    /**
     * @param  int|null  $group
     */
    public function setGroup(?int $group): void
    {
        $this->group = $group;
    }

    /**
     * @return string|null
     */
    public function getCallbackLink(): ?string
    {
        return $this->callbackLink;
    }

    /**
     * @param  string|null  $callbackLink
     */
    public function setCallbackLink(?string $callbackLink): void
    {
        $this->callbackLink = $callbackLink;
    }
}
