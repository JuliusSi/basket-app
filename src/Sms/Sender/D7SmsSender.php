<?php

declare(strict_types=1);

namespace Src\Sms\Sender;

use Core\Helpers\Traits\StringToBinaryConverter;
use DateTime;
use Src\Sms\Client\Response\BatchSmsResponse;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Model\Message;
use Src\Sms\Model\MessageBag;
use Src\Sms\Repository\D7SmsRepository;
use Src\Sms\Validator\SmsValidator;

class D7SmsSender implements SmsSender
{
    use StringToBinaryConverter;

    public function __construct(private D7SmsRepository $smsBatchRepository, private SmsValidator $smsValidator)
    {
    }

    /**
     * @param string[] $recipients
     * @param string[] $messages
     *
     * @throws SmsSendingException
     */
    public function send(string $sender, array $recipients, array $messages, ?DateTime $dateToSend = null): void
    {
        if ($dateToSend) {
            throw new SmsSendingException('D7 provider not supporting dateToSend parameter');
        }

        $this->validate($sender, $recipients, $messages);
        $this->sendMessages($this->buildMessageBag($sender, $recipients, $messages));
    }

    public function sendQueued(string $sender, array $recipients, array $messages, ?DateTime $dateToSend = null): void
    {
        // TODO: Implement sendViaQueue() method.
    }

    /**
     * @param string[] $recipients
     * @param string[] $messages
     */
    private function buildMessageBag(string $sender, array $recipients, array $messages): MessageBag
    {
        $bag = new MessageBag();
        $bag->setMessages($this->buildMessageRequests($sender, $recipients, $messages));

        return $bag;
    }

    /**
     * @param string[] $recipients
     * @param string[] $messages
     *
     * @return Message[]
     */
    private function buildMessageRequests(string $sender, array $recipients, array $messages): array
    {
        $messageRequests = [];
        foreach ($messages as $message) {
            $messageRequests[] = $this->buildMessageRequest($sender, $recipients, $message);
        }

        return $messageRequests;
    }

    private function buildMessageRequest(string $sender, array $recipients, string $message): Message
    {
        $request = new Message();
        $request->setContent($this->convert($message));
        $request->setTo($recipients);
        $request->setFrom($sender);

        return $request;
    }

    /**
     * @throws SmsSendingException
     */
    private function sendMessages(MessageBag $messageBag): ?BatchSmsResponse
    {
        return $this->smsBatchRepository->sendMessages($messageBag);
    }

    /**
     * @param string[] $recipients
     * @param string[] $messages
     *
     * @throws SmsSendingException
     */
    private function validate(string $sender, array $recipients, array $messages): void
    {
        $this->smsValidator->validate($sender, $recipients, $messages);
    }
}
