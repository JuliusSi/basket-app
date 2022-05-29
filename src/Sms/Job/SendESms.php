<?php

declare(strict_types=1);

namespace Src\Sms\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Model\ESms;
use Src\Sms\Repository\ESmsRepository;

class SendESms implements ShouldQueue
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

    public function __construct(private readonly ESms $sms)
    {
        $this->delay($this->sms->whenToSend());
    }

    /**
     * @throws SmsSendingException
     */
    public function handle(ESmsRepository $repository): void
    {
        $repository->send($this->sms);
    }

    public function tags(): array
    {
        return ['send_sms', 'recipient:'.$this->sms->recipient()];
    }
}
