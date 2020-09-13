<?php

namespace Src\Sms\Repository;

use Exception;
use Src\Sms\Client\DefaultClient;
use Src\Sms\Client\Request\MessagesRequest;
use Src\Sms\Client\Response\Response;

/**
 * Class SmsBatchRepository
 * @package Src\Sms\Repository
 */
class SmsBatchRepository
{
    /**
     * @var DefaultClient
     */
    private DefaultClient $client;

    /**
     * SmsBatchRepository constructor.
     * @param  DefaultClient  $client
     */
    public function __construct(DefaultClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param  MessagesRequest  $request
     * @return Response
     * @throws Exception
     */
    public function sendMessages(MessagesRequest $request): Response
    {
        return $this->client->getDeserializedResponse($request, Response::class);
    }
}
