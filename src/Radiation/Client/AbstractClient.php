<?php

namespace Src\Radiation\Client;

use Core\Helpers\Traits\RequestOptionsBuildingTrait;
use Core\Helpers\Traits\SerializationTrait;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;

/**
 * Class AbstractClient
 * @package Src\Radiation\Client
 */
abstract class AbstractClient
{
    use SerializationTrait;
    use RequestOptionsBuildingTrait;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * AbstractClient constructor.
     * @param  Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param  RequestInterface  $request
     * @param  string  $class
     *
     * @return mixed
     * @throws Exception
     */
    public function getDeserializedResponse(RequestInterface $request, string $class): mixed
    {
        $response = $this->getRawResponse($request);
        $content = $response->getBody()->getContents();
        $this->handleResponse($request, $content);

        return $this->deserialize($content, $class);
    }

    /**
     * @param  RequestInterface  $request
     * @return ResponseInterface
     * @throws Exception
     */
    private function getRawResponse(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->call($request);
        } catch (GuzzleException $exception) {
            $message = sprintf('Cannot get response from %s. %s', $request->getUri(), $exception->getMessage());
            $this->logAndThrowException($message, Exception::class);
        }
    }

    /**
     * @param  RequestInterface  $request
     * @param  string|null  $content
     * @throws Exception
     */
    private function handleResponse(RequestInterface $request, ?string $content): void
    {
        if (!$content) {
            $message = sprintf('Empty response from %s.', $request->getUri());
            $this->logAndThrowException($message, Exception::class);
        }
        $message = sprintf('Request: %s, Response: %s', $request->getBody(), $content);
        Log::channel('client')->info($message);
    }

    /**
     * @param  RequestInterface  $request
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function call(RequestInterface $request): ResponseInterface
    {
        return $this->client->request($request->getMethod(), $request->getUri(), $this->buildOptions($request));
    }

    /**
     * @param  string  $message
     * @param  string  $exception
     * @throws Exception
     */
    private function logAndThrowException(string $message, string $exception): void
    {
        Log::channel('client')->info($message);
        throw new $exception;
    }
}
