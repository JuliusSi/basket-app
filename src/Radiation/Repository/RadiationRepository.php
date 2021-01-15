<?php

namespace Src\Radiation\Repository;

use Exception;
use Src\Radiation\Client\DefaultClient;
use Src\Radiation\Client\Request\DefaultRequest;
use Src\Radiation\Client\Response\Response;

/**
 * Class RadiationRepository
 * @package Src\Radiation\Repository
 */
class RadiationRepository
{
    /**
     * @var DefaultClient
     */
    private DefaultClient $client;

    /**
     * RadiationRepository constructor.
     * @param  DefaultClient  $client
     */
    public function __construct(DefaultClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function find(): Response
    {
        return $this->client->getDeserializedResponse($this->buildRequest(), Response::class);
    }

    /**
     * @return DefaultRequest
     */
    private function buildRequest(): DefaultRequest
    {
        return new DefaultRequest();
    }
}
