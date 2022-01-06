<?php

declare(strict_types=1);

namespace Src\Sms\Repository;

use Src\Sms\Job\ESmsCreated;
use Src\Sms\Model\ESms;

class ESmsRepository
{
    /**
     * @param  ESms[]  $smsModels
     *
     * @return void
     */
    public function sendMessages(array $smsModels): void
    {
        foreach ($smsModels as $smsModel) {
            ESmsCreated::dispatch($smsModel);
        }
    }
}
