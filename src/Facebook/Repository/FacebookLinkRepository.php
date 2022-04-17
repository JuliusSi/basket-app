<?php

declare(strict_types=1);

namespace Src\Facebook\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Src\Facebook\Client\DefaultClient;
use Src\Facebook\Client\Request\FacebookLinkPostRequest;
use Src\Facebook\Client\Request\FacebookLinkPostRequestBody;
use Src\Facebook\Client\Response\Response;

class FacebookLinkRepository
{
    public function __construct(private DefaultClient $client)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function post(FacebookLinkPostRequestBody $postRequest): Response
    {
        return $this->client->getDeserializedResponse($this->buildRequest($postRequest), Response::class);
    }

    private function buildRequest(FacebookLinkPostRequestBody $postRequest): FacebookLinkPostRequest
    {
        $request = new FacebookLinkPostRequest();
        $request->setBodyRequest($postRequest);

        return $request;
    }
}
