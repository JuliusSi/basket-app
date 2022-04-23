<?php

declare(strict_types=1);

namespace Src\Sms\Repository;

use Src\Sms\Client\ESmsClient;
use Src\Sms\Client\Request\ESmsRequest;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Job\SendESms;
use Src\Sms\Model\ESms;

class ESmsRepository
{
    public function __construct(private readonly ESmsClient $client)
    {
    }

    /**
     * @param ESms[] $smsModels
     */
    public function addMessagesToQueue(array $smsModels): void
    {
        foreach ($smsModels as $smsModel) {
            SendESms::dispatch($smsModel);
        }
    }

    /**
     * @throws SmsSendingException
     */
    public function sendMessage(ESms $sms): string
    {
        return $this->client->getResponse(new ESmsRequest($sms));
    }

    /**
     * @throws SmsSendingException
     */
    public function sendMessages(array $smsList): void
    {
        foreach ($smsList as $sms) {
            $this->sendMessage($sms);
        }
    }
}
