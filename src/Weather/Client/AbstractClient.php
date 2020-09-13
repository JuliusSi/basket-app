<?php

namespace Src\Weather\Client;

use GuzzleHttp\Exception\GuzzleException;
use Src\Weather\Client\Request\AbstractRequest;
use Src\Weather\Client\Traits\SerializationTrait;
use GuzzleHttp\Client;

/**
 * Class AbstractClient
 * @package Src\Weather\Client
 */
abstract class AbstractClient
{
    use SerializationTrait;

    /**
     * @param  AbstractRequest  $request
     * @param  string  $class
     *
     * @return mixed|null
     * @throws GuzzleException
     */
    public function getDeserializedResponse(AbstractRequest $request, string $class)
    {
        $response = $this->getRawResponse($request);

        return $response ? $this->deserialize($response, $class) : null;
    }

    /**
     * @param  AbstractRequest  $request
     *
     * @return string
     * @throws GuzzleException
     */
    public function getRawResponse(AbstractRequest $request): string
    {
        $client = new Client();
        $rawContent = $client->request($request->getMethod(), $request->getUri(), $this->buildOptions($request));

        return $rawContent->getBody()->getContents();
    }

    /**
     * @param  AbstractRequest  $request
     * @return array
     */
    private function buildOptions(AbstractRequest $request): array
    {
        $options = [];
        if ($headers = $request->getHeaders()) {
            $options['headers'] = $headers;
        }
        if ($body = $request->getBody()) {
            $options['body'] = $body;
        }
        if ($query = $request->getQuery()) {
            $options['query'] = $query;
        }

        return $options;
    }
}
