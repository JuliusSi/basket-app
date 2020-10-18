<?php

namespace Src\Sms\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Verification
 * @package Src\Sms\Model
 */
class Verification
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("otp_code")
     * @var string
     */
    private string $otpCode;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("otp_id")
     * @var string
     */
    private string $otpId;

    /**
     * @return string
     */
    public function getOtpCode(): string
    {
        return $this->otpCode;
    }

    /**
     * @param  string  $otpCode
     */
    public function setOtpCode(string $otpCode): void
    {
        $this->otpCode = $otpCode;
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
}
