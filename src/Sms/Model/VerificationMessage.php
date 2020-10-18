<?php

namespace Src\Sms\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class VerificationMessage
 * @package Src\Sms\Model
 */
class VerificationMessage
{
    private const DEFAULT_VERIFICATION_LIFE_TIME = 900;

    /**
     * @JMS\Type("integer")
     * @var int
     */
    private int $expiry = self::DEFAULT_VERIFICATION_LIFE_TIME;

    /**
     * @JMS\Type("string")
     * @var string
     */
    private string $message;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("mobile")
     * @var string
     */
    private string $phoneNumber;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("sender_id")
     * @var string
     */
    private string $senderName;

    /**
     * @return int
     */
    public function getExpiry(): int
    {
        return $this->expiry;
    }

    /**
     * @param  int  $expiry
     */
    public function setExpiry(int $expiry): void
    {
        $this->expiry = $expiry;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param  string  $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param  string  $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * @param  string  $senderName
     */
    public function setSenderName(string $senderName): void
    {
        $this->senderName = $senderName;
    }
}
