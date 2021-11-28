<?php

declare(strict_types=1);

namespace Src\Sms\Client;

use Core\Helpers\Traits\RequestOptionsBuildingTrait;
use Core\Helpers\Traits\SerializationTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;
use Src\Sms\Exception\SmsSendingException;

abstract class AbstractClient
{
    use SerializationTrait;
    use RequestOptionsBuildingTrait;

    public function __construct(private Client $client)
    {
    }

    /**
     * @param  RequestInterface  $request
     * @param  string  $class
     *
     * @return mixed
     * @throws SmsSendingException
     */
    public function getDeserializedResponse(RequestInterface $request, string $class): mixed
    {
        $response = $this->getResponse($request);

        return $this->deserialize($response, $class);
    }

    /**
     * @param  RequestInterface  $request
     *
     * @return string
     *
     * @throws SmsSendingException
     */
    public function getResponse(RequestInterface $request): string
    {
        $environment = App::environment();
        if ($environment !== 'local') {
            $message = sprintf(
                'Sms message sending is enabled only for prod env. Current env: %s. Request: %s.',
                $environment, $request->getBody()
            );
            $this->logAndThrowException($message);
        }

        $response =  $this->getRawResponse($request);
        $content = $response->getBody()->getContents();
        $this->handleResponse($request, $content);

        return $content;
    }

    /**
     * @param  RequestInterface  $request
     * @return ResponseInterface
     * @throws SmsSendingException
     */
    private function getRawResponse(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->call($request);
        } catch (GuzzleException $exception) {
            $message = sprintf('Cannot get response from %s. %s', $request->getUri(), $exception->getMessage());
            $this->logAndThrowException($message);
        }
    }

    /**
     * @param  RequestInterface  $request
     * @param  string|null  $content
     * @throws SmsSendingException
     */
    private function handleResponse(RequestInterface $request, ?string $content): void
    {
        if (!$content) {
            $message = sprintf('Empty response from %s.', $request->getUri());
            $this->logAndThrowException($message);
        }
        $message = sprintf('Request body: %s, Response: %s', $request->getBody(), $content);
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
     *
     * @throws SmsSendingException
     */
    private function logAndThrowException(string $message): void
    {
        Log::channel('client')->info($message);
        throw new SmsSendingException($message);
    }
}
