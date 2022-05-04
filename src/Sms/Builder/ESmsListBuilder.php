<?php

declare(strict_types=1);

namespace Src\Sms\Builder;

use DateTime;
use Src\Sms\Model\ESms;

class ESmsListBuilder
{
    /**
     * @param string[] $recipients
     * @param string[] $messages
     *
     * @return ESms[]
     */
    public function build(string $sender, array $recipients, array $messages, ?DateTime $dateToSend): array
    {
        $smsModels = [];
        foreach ($recipients as $recipient) {
            foreach ($messages as $message) {
                $smsModels[] = $this->createESms($sender, $recipient, $message, $dateToSend);
            }
        }

        return $smsModels;
    }

    private function createESms(string $sender, string $recipient, string $message, ?DateTime $dateToSend): ESms
    {
        return ESms::create(
            sender: $sender,
            recipient: $recipient,
            content: $message,
            dateWhenToSend: $dateToSend,
        );
    }
}
