<?php

declare(strict_types=1);

namespace Src\Sms\Service;

use DateTime;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Model\ESms;
use Src\Sms\Repository\ESmsRepository;

class ESmsSendingService extends AbstractSmsSendingService implements SmsSendingService
{
    public function __construct(private ESmsRepository $smsRepository)
    {
    }

    /**
     * @param  string  $sender
     * @param  string[]  $recipients
     * @param  string[]  $messages
     * @param  DateTime|null  $dateToSend
     *
     * @throws SmsSendingException
     */
    public function send(string $sender, array $recipients, array $messages, ?DateTime $dateToSend = null): void
    {
        $this->validate($sender, $recipients, $messages);
        $this->smsRepository->sendMessages($this->buildSmsModels($sender, $recipients, $messages, $dateToSend));
    }

    /**
     * @param  string  $sender
     * @param  string[]  $recipients
     * @param  string[]  $messages
     * @param  DateTime|null  $dateToSend
     *
     * @return ESms[]
     */
    private function buildSmsModels(string $sender, array $recipients, array $messages, ?DateTime $dateToSend): array
    {
        $smsModels = [];
        foreach ($recipients as $recipient) {
            foreach ($messages as $message) {
                $smsModels[] = $this->buildSms($sender, $recipient, $message, $dateToSend);
            }
        }

        return $smsModels;
    }

    private function buildSms(string $sender, string $recipient, string $message, ?DateTime $dateToSend): ESms
    {
        $model = new ESms();
        $model->setContent($message);
        $model->setRecipient($recipient);
        $model->setSender($sender);
        $model->setDateWhenToSend($dateToSend);

        return $model;
    }
}
