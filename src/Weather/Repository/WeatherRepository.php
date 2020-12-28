<?php

namespace Src\Weather\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Src\Weather\Client\DefaultClient;
use Src\Weather\Client\Request\DefaultRequest;
use Src\Weather\Client\Response\Response;

/**
 * Class WeatherRepository
 * @package Src\Weather\Repository
 */
class WeatherRepository
{
    /**
     * @var DefaultClient
     */
    private DefaultClient $client;

    /**
     * WeatherProvider constructor.
     *
     * @param  DefaultClient  $client
     */
    public function __construct(DefaultClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param  string  $placeCode
     * @return Response|null
     * @throws GuzzleException
     */
    public function find(string $placeCode): ?Response
    {
        return $this->client->getDeserializedResponse($this->buildRequest($placeCode), Response::class);
    }

    /**
     * @param  string  $place
     * @return DefaultRequest
     */
    private function buildRequest(string $place): DefaultRequest
    {
        $request = new DefaultRequest();
        $request->setPlace($place);

        return $request;
    }
}
