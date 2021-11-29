<?php

declare(strict_types=1);

namespace Src\Sms\Listener;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Sms\Client\ESmsClient;
use Src\Sms\Client\Request\ESmsRequest;
use Src\Sms\Event\ESmsCreated;
use Src\Sms\Exception\SmsSendingException;
use Illuminate\Foundation\Bus\Dispatchable;

class SendESms implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Dispatchable;

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

    public function __construct(private ESmsClient $client)
    {
    }

    /**
     * @throws SmsSendingException
     */
    public function handle(ESmsCreated $createdSms): void
    {
        $this->client->getResponse(new ESmsRequest($createdSms->sms));
    }
}
