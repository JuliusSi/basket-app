<?php

declare(strict_types=1);

namespace App\Chat\Job;

use App\Chat\Message\Service\MessageService;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly User $user, private readonly string $message)
    {
    }

    public function handle(MessageService $service): void
    {
        $service->send($this->user, $this->message);
    }

    public function tags(): array
    {
        return ['send_chat_message'];
    }
}
