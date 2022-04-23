<?php

declare(strict_types=1);

namespace Src\Weather\Client;

use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;
use Core\Helpers\Traits\RequestOptionsBuildingTrait;
use Core\Helpers\Traits\SerializationTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class AbstractClient
{
    use SerializationTrait;
    use RequestOptionsBuildingTrait;

    /**
     * @throws GuzzleException
     */
    public function getDeserializedResponse(RequestInterface $request, string $class): mixed
    {
        $response = $this->getRawResponse($request);

        return $response ? $this->deserialize($response, $class) : null;
    }

    /**
     * @throws GuzzleException
     */
    public function getRawResponse(RequestInterface $request): string
    {
        $client = new Client();
        $response = $client->request($request->getMethod(), $request->getUri(), $this->buildOptions($request));

        return $response->getBody()->getContents();
    }
}
