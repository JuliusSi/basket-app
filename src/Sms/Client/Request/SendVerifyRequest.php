<?php

namespace Src\Sms\Client\Request;

use Src\Sms\Model\VerificationMessage;

/**
 * Class VerificationRequest
 * @package Src\Sms\Client\Request
 */
class SendVerifyRequest extends AbstractRequest
{
    /**
     * @var VerificationMessage
     */
    private VerificationMessage $message;

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [
            'Authorization' => 'Token ' . config('provider.d7sms_rapid_sms_verify_api_token'),
            'x-rapidapi-host' => config('provider.d7sms_rapid_api_verify_host'),
            'x-rapidapi-key' => config('provider.d7sms_rapid_api_key'),
            'Content-type' => 'application/json',
        ];
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->serialize($this->getMessage());
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return config('provider.d7sms_rapid_send_verify_api_endpoint');
    }

    /**
     * @return VerificationMessage
     */
    public function getMessage(): VerificationMessage
    {
        return $this->message;
    }

    /**
     * @param  VerificationMessage  $message
     */
    public function setMessage(VerificationMessage $message): void
    {
        $this->message = $message;
    }
}
