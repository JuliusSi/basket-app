<?php

namespace Src\Facebook\Client;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Src\Facebook\Client\Request\AbstractRequest;
use Src\Facebook\Client\Traits\SerializationTrait;
use Src\Sms\Exception\SmsSendingException;

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
        if (!App::isProduction()) {
            $message = sprintf(
                'Posting to facebook is enabled only for production env. Current env: %s. Request: %s.',
                env('APP_ENV'),
                $request->getBody()
            );
            $this->logAndThrowException($message);
        }

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

    /**
     * @throws Exception
     */
    private function logAndThrowException(string $message): void
    {
        Log::channel('client')->info($message);

        throw new Exception($message);
    }
}
