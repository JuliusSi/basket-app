<?php

namespace Src\Sms\Repository;

use Src\Sms\Client\DefaultClient;
use Src\Sms\Client\Request\D7SmsRequest;
use Src\Sms\Client\Response\BatchSmsResponse;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Model\MessageBag;

/**
 * Class SmsBatchRepository
 * @package Src\Sms\Repository
 */
class D7SmsRepository
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
     * @param  MessageBag  $messageBag
     * @return BatchSmsResponse
     * @throws SmsSendingException
     */
    public function sendMessages(MessageBag $messageBag): BatchSmsResponse
    {
        $request = new D7SmsRequest();
        $request->setMessageBag($messageBag);

        return $this->client->getDeserializedResponse($request, BatchSmsResponse::class);
    }
}
