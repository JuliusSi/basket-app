<?php

declare(strict_types=1);

namespace Src\Sms\Sender;

use DateTime;
use Src\Sms\Exception\SmsSendingException;

interface SmsSender
{
    /**
     * @throws SmsSendingException
     */
    public function send(string $sender, array $recipients, array $messages, ?DateTime $dateToSend = null): void;

    /**
     * @throws SmsSendingException
     */
    public function sendQueued(string $sender, array $recipients, array $messages, ?DateTime $dateToSend = null): void;
}
