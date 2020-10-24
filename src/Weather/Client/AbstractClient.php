<?php

namespace Src\Weather\Client;

use Core\Helpers\Traits\RequestOptionsBuildingTrait;
use GuzzleHttp\Exception\GuzzleException;
use Core\Helpers\Traits\SerializationTrait;
use GuzzleHttp\Client;
use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;

/**
 * Class AbstractClient
 * @package Src\Weather\Client
 */
abstract class AbstractClient
{
    use SerializationTrait;
    use RequestOptionsBuildingTrait;

    /**
     * @param  RequestInterface  $request
     * @param  string  $class
     *
     * @return mixed|null
     * @throws GuzzleException
     */
    public function getDeserializedResponse(RequestInterface $request, string $class)
    {
        $response = $this->getRawResponse($request);

        return $response ? $this->deserialize($response, $class) : null;
    }

    /**
     * @param  RequestInterface  $request
     *
     * @return string
     * @throws GuzzleException
     */
    public function getRawResponse(RequestInterface $request): string
    {
        $client = new Client();
        $rawContent = $client->request($request->getMethod(), $request->getUri(), $this->buildOptions($request));

        return $rawContent->getBody()->getContents();
    }
}
