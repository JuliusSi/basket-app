<?php

declare(strict_types=1);

namespace Src\Sms\Service;

use DateTime;
use Src\Sms\Builder\ESmsListBuilder;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Repository\ESmsRepository;
use Src\Sms\Validator\SmsValidator;

class ESmsSendingService implements SmsSendingService
{
    public function __construct(
        private ESmsRepository $smsRepository,
        private SmsValidator $smsValidator,
        private ESmsListBuilder $builder
    ) {
    }

    /**
     * @param string[] $recipients
     * @param string[] $messages
     *
     * @throws SmsSendingException
     */
    public function send(string $sender, array $recipients, array $messages, ?DateTime $dateToSend = null): void
    {
        $this->smsValidator->validate($sender, $recipients, $messages, $dateToSend);
        $smsList = $this->builder->build($sender, $recipients, $messages, $dateToSend);
        $this->smsRepository->sendMessages($smsList);
    }
}
