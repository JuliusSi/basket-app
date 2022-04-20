<?php

declare(strict_types=1);

namespace Src\Weather\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Src\Weather\Client\DefaultClient;
use Src\Weather\Client\Request\DefaultRequest;
use Src\Weather\Client\Response\Response;

class WeatherRepository
{
    private DefaultClient $client;

    public function __construct(DefaultClient $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     */
    public function find(string $placeCode): ?Response
    {
        return $this->client->getDeserializedResponse($this->buildRequest($placeCode), Response::class);
    }

    private function buildRequest(string $place): DefaultRequest
    {
        $request = new DefaultRequest();
        $request->setPlace($place);

        return $request;
    }
}
