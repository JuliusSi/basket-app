<?php

declare(strict_types=1);

namespace Src\Sms\Sender;

use DateTime;
use Src\Sms\Builder\ESmsListBuilder;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Model\ESms;
use Src\Sms\Modifier\LongSmsModifier;
use Src\Sms\Repository\ESmsRepository;
use Src\Sms\Validator\SmsValidator;

class ESmsSender implements SmsSender
{
    public function __construct(
        private readonly ESmsRepository $smsRepository,
        private readonly SmsValidator $smsValidator,
        private readonly ESmsListBuilder $builder,
        private readonly LongSmsModifier $modifier
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
        $smsList = $this->prepare($sender, $recipients, $messages, $dateToSend);

        $this->smsRepository->sendList($smsList);
    }

    public function sendQueued(string $sender, array $recipients, array $messages, ?DateTime $dateToSend = null): void
    {
        $smsList = $this->prepare($sender, $recipients, $messages, $dateToSend);

        $this->smsRepository->sendQueued($smsList);
    }

    /**
     * @param string[] $recipients
     * @param string[] $messages
     *
     * @return ESms[]
     * @throws SmsSendingException
     */
    private function prepare(string $sender, array $recipients, array $messages, ?DateTime $dateToSend): array
    {
        $messages = $this->modifier->modify($messages);
        $this->smsValidator->validate($sender, $recipients, $messages, $dateToSend);

        return $this->builder->build($sender, $recipients, $messages, $dateToSend);
    }
}
