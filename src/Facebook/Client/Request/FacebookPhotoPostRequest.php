<?php

namespace Src\Facebook\Client\Request;

use Psr\Http\Message\UriInterface;
use Src\Facebook\Client\Traits\SerializationTrait;

/**
 * Class FacebookPhotoPostRequest
 * @package Src\Facebook\Client\Request
 */
class FacebookPhotoPostRequest extends AbstractRequest
{
    use SerializationTrait;

    /**
     * @var FacebookPhotoPostRequestBody
     */
    private FacebookPhotoPostRequestBody $requestBody;

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
        return config('provider.facebook_photos_api_endpoint');
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
        return $this->serialize($this->getRequestBody());
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
     * @return FacebookPhotoPostRequestBody
     */
    public function getRequestBody(): FacebookPhotoPostRequestBody
    {
        return $this->requestBody;
    }

    /**
     * @param  FacebookPhotoPostRequestBody  $requestBody
     */
    public function setRequestBody(FacebookPhotoPostRequestBody $requestBody): void
    {
        $this->requestBody = $requestBody;
    }
}
