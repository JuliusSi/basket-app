<?php

declare(strict_types=1);

namespace Src\Sms\Repository;

use Src\Sms\Client\ESmsClient;
use Src\Sms\Client\Request\ESmsRequest;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Model\ESms;

class ESmsRepository
{
    public function __construct(private ESmsClient $client)
    {
    }

    /**
     * @param  ESms[]  $smsModels
     *
     * @return void
     *
     * @throws SmsSendingException
     */
    public function sendMessages(array $smsModels): void
    {
        foreach ($smsModels as $smsModel) {
            $this->client->getResponse(new ESmsRequest($smsModel));
        }
    }
}
