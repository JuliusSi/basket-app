<?php

namespace Src\Sms\Client\Response;

use JMS\Serializer\Annotation as JMS;

/**
 * Class SendVerifyResponse
 * @package Src\Sms\Client\Response
 */
class SendVerifyResponse
{
    private const STATUS_OPEN = 'open';

    /**
     * @JMS\Type("integer")
     * @var int
     */
    private int $expiry;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("otp_id")
     * @var string
     */
    private string $otpId;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("status")
     * @var string
     */
    private string $status;

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
    public function getOtpId(): string
    {
        return $this->otpId;
    }

    /**
     * @param  string  $otpId
     */
    public function setOtpId(string $otpId): void
    {
        $this->otpId = $otpId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param  string  $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isStatusOpen(): bool
    {
        return $this->status === self::STATUS_OPEN;
    }
}
