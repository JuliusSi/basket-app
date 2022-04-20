<?php

declare(strict_types=1);

namespace Src\Sms\Client;

use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;
use Core\Helpers\Traits\RequestOptionsBuildingTrait;
use Core\Helpers\Traits\SerializationTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Src\Sms\Exception\SmsSendingException;

abstract class AbstractClient
{
    use SerializationTrait;
    use RequestOptionsBuildingTrait;

    public function __construct(private readonly Client $client)
    {
    }

    /**
     * @throws SmsSendingException
     */
    public function getDeserializedResponse(RequestInterface $request, string $class): mixed
    {
        $response = $this->getResponse($request);

        return $this->deserialize($response, $class);
    }

    /**
     * @throws SmsSendingException
     */
    public function getResponse(RequestInterface $request): string
    {
        if (!App::isProduction()) {
            $message = sprintf(
                'Sms message sending is enabled only for production env. Current env: %s. Request: %s.',
                env('APP_ENV'),
                $request->getBody()
            );
            $this->logAndThrowException($message);
        }

        $response = $this->getRawResponse($request);
        $content = $response->getBody()->getContents();
        $this->handleResponse($request, $content);

        return $content;
    }

    /**
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
     * @throws SmsSendingException
     */
    private function handleResponse(RequestInterface $request, ?string $content): void
    {
        if (!$content) {
            $message = sprintf('Empty response from %s.', $request->getUri());
            $this->logAndThrowException($message);
        }
        $message = 'Successfully get response.';
        Log::channel('client')->info($message, [
            'request_uri' => $request->getUri(),
            'request_query' => $request->getQuery(),
            'response_body' => $content,
        ]);
    }

    /**
     * @throws GuzzleException
     */
    private function call(RequestInterface $request): ResponseInterface
    {
        return $this->client->request($request->getMethod(), $request->getUri(), $this->buildOptions($request));
    }

    /**
     * @throws SmsSendingException
     */
    private function logAndThrowException(string $message): void
    {
        Log::channel('client')->info($message);

        throw new SmsSendingException($message);
    }
}
