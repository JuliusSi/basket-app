<?php

namespace App\Notifier\Model;

/**
 * Class Notification
 * @package App\Notifier\Model
 */
class Notification
{
    /**
     * @var string
     */
    private string $content;

    /**
     * @var string
     */
    private string $imageUrl;

    /**
     * @var string[]
     */
    private array $smsRecipients = [];

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
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param  string  $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string[]
     */
    public function getSmsRecipients(): array
    {
        return $this->smsRecipients;
    }

    /**
     * @param  string[]  $smsRecipients
     */
    public function setSmsRecipients(array $smsRecipients): void
    {
        $this->smsRecipients = $smsRecipients;
    }
}
