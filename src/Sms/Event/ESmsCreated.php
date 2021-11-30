<?php

declare(strict_types=1);

namespace Src\Sms\Event;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Sms\Model\ESms;

class ESmsCreated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public ESms $sms)
    {
    }
}
