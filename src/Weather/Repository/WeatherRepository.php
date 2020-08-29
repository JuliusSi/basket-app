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
    public const PLACE_CODE_VILNIUS_VIRSULISKES = 'vilnius-virsuliskes';

    public const AVAILABLE_PLACE_CODES = [
        self::PLACE_CODE_VILNIUS_VIRSULISKES,
    ];

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
     * @param  DefaultRequest  $request
     * @return Response|null
     * @throws GuzzleException
     */
    public function find(DefaultRequest $request): ?Response
    {
        return $this->client->getDeserializedResponse($request, Response::class);
    }
}
