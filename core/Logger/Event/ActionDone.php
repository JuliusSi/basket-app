<?php

declare(strict_types=1);

namespace Core\Logger\Event;

use Core\Logger\Model\Log;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActionDone
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Log $log)
    {
    }
}
