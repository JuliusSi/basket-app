<?php

declare(strict_types=1);

namespace App\Notifier\Model;

class Notification
{
    private string $notifier;

    private string $content;

    /**
     * @var string[]
     */
    private array $smsRecipients = [];

    public function __construct(
        private readonly ?FacebookNotification $facebookNotification = null,
        private readonly ?SmsNotification $smsNotification = null,
        private readonly ?ChatNotification $chatNotification = null,
    ) {
    }

    public function getNotifier(): string
    {
        return $this->notifier;
    }

    public function setNotifier(string $notifier): void
    {
        $this->notifier = $notifier;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string[]
     */
    public function getSmsRecipients(): array
    {
        return $this->smsRecipients;
    }

    /**
     * @param string[] $smsRecipients
     */
    public function setSmsRecipients(array $smsRecipients): void
    {
        $this->smsRecipients = $smsRecipients;
    }

    public function facebookNotification(): ?FacebookNotification
    {
        return $this->facebookNotification;
    }

    public function smsNotification(): ?SmsNotification
    {
        return $this->smsNotification;
    }

    public function chatNotification(): ?ChatNotification
    {
        return $this->chatNotification;
    }
}
