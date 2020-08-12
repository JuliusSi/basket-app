<?php

namespace Src\Facebook\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Src\Facebook\Client\DefaultClient;
use Src\Facebook\Client\Request\FacebookPhotoPostRequest;
use Src\Facebook\Client\Request\FacebookPhotoPostRequestBody;
use Src\Facebook\Client\Response\Response;

/**
 * Class FacebookPhotoRepository
 * @package Src\Facebook\Repository
 */
class FacebookPhotoRepository
{
    /**
     * @var DefaultClient
     */
    private DefaultClient $client;

    /**
     * FacebookPhotoRepository constructor.
     * @param  DefaultClient  $client
     */
    public function __construct(DefaultClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param  FacebookPhotoPostRequestBody  $postRequest
     * @return Response
     * @throws GuzzleException
     */
    public function post(FacebookPhotoPostRequestBody $postRequest): Response
    {
        return $this->client->getDeserializedResponse($this->buildRequest($postRequest), Response::class);
    }

    /**
     * @param  FacebookPhotoPostRequestBody  $postRequest
     * @return FacebookPhotoPostRequest
     */
    private function buildRequest(FacebookPhotoPostRequestBody $postRequest): FacebookPhotoPostRequest
    {
        $request = new FacebookPhotoPostRequest();
        $request->setRequestBody($postRequest);

        return $request;
    }
}
