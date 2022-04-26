<?php

declare(strict_types=1);

namespace Src\Radiation\Client;

use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;
use Core\Helpers\Traits\RequestOptionsBuildingTrait;
use Core\Helpers\Traits\SerializationTrait;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractClient
{
    use SerializationTrait;
    use RequestOptionsBuildingTrait;

    private Client $client;

    /**
     * AbstractClient constructor.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
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
     * @throws GuzzleException
     */
    private function call(RequestInterface $request): ResponseInterface
    {
        return $this->client->request($request->getMethod(), $request->getUri(), $this->buildOptions($request));
    }

    /**
     * @throws Exception
     */
    private function logAndThrowException(string $message, string $exception): void
    {
        Log::channel('client')->info($message);

        throw new $exception();
    }
}
