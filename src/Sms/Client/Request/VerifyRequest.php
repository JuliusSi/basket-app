<?php

namespace Src\Sms\Client\Request;

use Src\Sms\Model\Verification;

/**
 * Class VerifyRequest
 * @package Src\Sms\Client\Request
 */
class VerifyRequest extends AbstractRequest
{
    /**
     * @var Verification
     */
    private Verification $verification;

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
        return $this->serialize($this->getVerification());
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return config('provider.d7sms_rapid__verify_api_endpoint');
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return Verification
     */
    public function getVerification(): Verification
    {
        return $this->verification;
    }

    /**
     * @param  Verification  $verification
     */
    public function setVerification(Verification $verification): void
    {
        $this->verification = $verification;
    }
}
