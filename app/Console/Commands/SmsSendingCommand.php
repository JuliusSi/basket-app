<?php

declare(strict_types=1);

namespace App\Console\Commands;

use DateTime;
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
        $sender = $this->ask('Enter sender name', 'test');
        $recipient = $this->ask('Enter recipient phone number (example: 37000000000)');
        $message = $this->ask('Enter message', 'test');
        $date = $this->ask(
            'Enter date when to send (example: 2009-01-01 22:00:00)',
            now()->addMinute()->format('Y-m-d H:i:s'));
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $date);

        $this->sendSms($sender, $recipient, $message, $dateTime);
    }

    private function sendSms(string $sender, string $recipient, string $message, DateTime $dateTime): void
    {
        try {
            $this->smsSendingService->send($sender, [$recipient], [$message], $dateTime);
            $this->info(sprintf('Message will be sent (%s)!', $dateTime->format('Y-m-d H:i:s')));
        } catch (SmsSendingException $exception) {
            $this->error($exception->getMessage());
        }
    }
}
