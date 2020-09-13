<?php

namespace Src\Sms\Client\Request;

/**
 * Class DefaultRequest
 * @package Src\Sms\Client\Request
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * @return string
     */
    abstract public function getBody(): string;

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [
            'Authorization' => 'Basic ' . config('provider.d7sms_rapid_api_token'),
            'x-rapidapi-host' => config('provider.d7sms_rapid_api_host'),
            'x-rapidapi-key' => config('provider.d7sms_rapid_api_key'),
            'Content-type' => 'application/json;charset=UTF-8',
            'Accept' => 'application/json',
        ];
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return config('provider.d7sms_rapid_send_batch_api_endpoint');
    }
}
