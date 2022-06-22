<?php

declare(strict_types=1);

namespace App\Notifier\Event;

use App\Notifier\Model\ChatNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChatNotificationCreated
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly ChatNotification $notification)
    {
    }
}
