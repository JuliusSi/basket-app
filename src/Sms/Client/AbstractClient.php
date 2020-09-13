<?php

namespace Src\Sms\Client;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Src\Sms\Client\Traits\SerializationTrait;
use Src\Sms\Client\Request\RequestInterface;

/**
 * Class AbstractClient
 * @package Src\Sms\Client
 */
abstract class AbstractClient
{
    use SerializationTrait;

    /**
     * @param  RequestInterface  $request
     * @param  string  $class
     *
     * @return mixed|null
     * @throws Exception
     */
    public function getDeserializedResponse(RequestInterface $request, string $class)
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
            $message = sprintf('Cannot get response from d7sms. %s', $exception->getMessage());
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
            $message = 'Empty response from d7sms.';
            $this->logAndThrowException($message, Exception::class);
        }

        Log::info(sprintf('Request: %s, Response: %s',$request->getBody(), $content));
    }

    /**
     * @param  RequestInterface  $request
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function call(RequestInterface $request): ResponseInterface
    {
        $client = new Client();

        return $client->request($request->getMethod(), $request->getUri(), $this->buildOptions($request));
    }

    /**
     * @param  string  $message
     * @param  string  $exception
     * @throws Exception
     */
    private function logAndThrowException(string $message, string $exception): void
    {
        Log::error($message);
        throw new $exception;
    }

    /**
     * @param  RequestInterface  $request
     * @return array
     */
    private function buildOptions(RequestInterface $request): array
    {
        $options = [];
        if ($headers = $request->getHeaders()) {
            $options['headers'] = $headers;
        }
        if ($body = $request->getBody()) {
            $options['body'] = $body;
        }

        return $options;
    }
}
