<?php

declare(strict_types=1);

namespace Src\Sms\Repository;

use Src\Sms\Job\GetWeatherInfo;
use Src\Sms\Model\ESms;

class ESmsRepository
{
    /**
     * @param ESms[] $smsModels
     */
    public function sendMessages(array $smsModels): void
    {
        foreach ($smsModels as $smsModel) {
            GetWeatherInfo::dispatch($smsModel);
        }
    }
}
