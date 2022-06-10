<?php

namespace Src\Facebook\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Src\Facebook\Client\Request\AbstractRequest;
use Src\Facebook\Client\Traits\SerializationTrait;

/**
 * Class AbstractClient.
 */
abstract class AbstractClient
{
    use SerializationTrait;

    /**
     * @throws GuzzleException
     *
     * @return null|mixed
     */
    public function getDeserializedResponse(AbstractRequest $request, string $class)
    {
        $response = $this->getRawResponse($request);

        return $response ? $this->deserialize($response, $class) : null;
    }

    /**
     * @throws GuzzleException
     */
    public function getRawResponse(AbstractRequest $request): string
    {
        $client = new Client();
        Log::channel('client')->info('Method: '.$request->getMethod());
        Log::channel('client')->info('Uri:'.$request->getUri());
        $response = $client->request($request->getMethod(), $request->getUri(), $this->buildOptions($request));

        return $response->getBody()->getContents();
    }

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
