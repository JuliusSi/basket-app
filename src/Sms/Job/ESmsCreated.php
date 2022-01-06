<?php

declare(strict_types=1);

namespace Src\Sms\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Sms\Client\ESmsClient;
use Src\Sms\Client\Request\ESmsRequest;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Model\ESms;

class ESmsCreated implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 30;

    public function __construct(public ESms $sms)
    {
        $this->delay($this->sms->whenToSend());
    }

    /**
     * @throws SmsSendingException
     */
    public function handle(ESmsClient $client): void
    {
        $client->getResponse(new ESmsRequest($this->sms));
    }
}
