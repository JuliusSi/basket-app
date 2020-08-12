<?php

namespace Src\Facebook\Client\Request;

use Psr\Http\Message\UriInterface;
use Src\Facebook\Client\Traits\SerializationTrait;

/**
 * Class FacebookLinkPostRequest
 * @package Src\Facebook\Client\Request
 */
class FacebookLinkPostRequest extends AbstractRequest
{
    use SerializationTrait;

    /**
     * @var FacebookLinkPostRequestBody
     */
    private FacebookLinkPostRequestBody $bodyRequest;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return UriInterface|string
     */
    public function getUri()
    {
        return config('provider.facebook_link_api_endpoint');
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return ['access_token' => config('provider.facebook_api_endpoint_access_token')];
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->serialize($this->getBodyRequest());
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @return FacebookLinkPostRequestBody
     */
    public function getBodyRequest(): FacebookLinkPostRequestBody
    {
        return $this->bodyRequest;
    }

    /**
     * @param  FacebookLinkPostRequestBody  $bodyRequest
     */
    public function setBodyRequest(FacebookLinkPostRequestBody $bodyRequest): void
    {
        $this->bodyRequest = $bodyRequest;
    }
}
