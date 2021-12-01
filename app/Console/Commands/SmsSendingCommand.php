<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Service\SmsSendingService;

class SmsSendingCommand extends Command
{
    protected $signature = 'sms:send';

    protected $description = 'Sends sms message';

    public function __construct(private SmsSendingService $smsSendingService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $sender = $this->ask('Enter sender name');
        $recipient = $this->ask('Enter recipient phone number(370)');
        $message = $this->ask('Enter message');

        $this->sendSms($sender, $recipient, $message);
    }

    private function sendSms(string $sender, string $recipient, string $message): void
    {
        try {
            $this->smsSendingService->send($sender, [$recipient], [$message]);
            $this->info('Message sent!');
        } catch (SmsSendingException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
