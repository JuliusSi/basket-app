<?php

namespace Src\Radiation\Client\Request;

/**
 * Class DefaultRequest
 * @package Src\Radiation\Client\Request
 */
class DefaultRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return config('provider.alpha_charlie_api_endpoint');
    }
}
