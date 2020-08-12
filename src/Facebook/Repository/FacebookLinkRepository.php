<?php

namespace Src\Facebook\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Src\Facebook\Client\DefaultClient;
use Src\Facebook\Client\Request\FacebookLinkPostRequest;
use Src\Facebook\Client\Request\FacebookLinkPostRequestBody;
use Src\Facebook\Client\Response\Response;

/**
 * Class FacebookLinkRepository
 * @package Src\Facebook\Repository
 */
class FacebookLinkRepository
{
    /**
     * @var DefaultClient
     */
    private DefaultClient $client;

    /**
     * FacebookLinkRepository constructor.
     * @param  DefaultClient  $client
     */
    public function __construct(DefaultClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param  FacebookLinkPostRequestBody  $postRequest
     * @return Response
     * @throws GuzzleException
     */
    public function post(FacebookLinkPostRequestBody $postRequest): Response
    {
        return $this->client->getDeserializedResponse($this->buildRequest($postRequest), Response::class);
    }

    /**
     * @param  FacebookLinkPostRequestBody  $postRequest
     * @return FacebookLinkPostRequest
     */
    private function buildRequest(FacebookLinkPostRequestBody $postRequest): FacebookLinkPostRequest
    {
        $request = new FacebookLinkPostRequest();
        $request->setBodyRequest($postRequest);

        return $request;
    }
}
