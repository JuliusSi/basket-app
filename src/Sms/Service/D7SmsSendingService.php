<?php

declare(strict_types=1);

namespace Src\Sms\Service;

use Core\Helpers\Traits\StringToBinaryConverter;
use DateTime;
use Src\Sms\Client\Response\BatchSmsResponse;
use Src\Sms\Exception\SmsSendingException;
use Src\Sms\Model\Message;
use Src\Sms\Model\MessageBag;
use Src\Sms\Repository\D7SmsRepository;

class D7SmsSendingService implements SmsSendingService
{
    use StringToBinaryConverter;

    public function __construct(private D7SmsRepository $smsBatchRepository)
    {
    }

    /**
     * @param  string  $sender
     * @param  string[]  $recipients
     * @param  string[]  $messages
     * @param  DateTime|null  $dateToSend
     *
     * @return void
     *
     * @throws SmsSendingException
     */
    public function send(string $sender, array $recipients, array $messages, ?DateTime $dateToSend = null): void
    {
        if (!$sender || !$recipients || !$messages) {
            throw new SmsSendingException('sender, recipients, messages must be filled');
        }

        if ($dateToSend) {
            throw new SmsSendingException('D7 not supporting this parameter');
        }

        $this->sendMessages($this->buildMessageBag($sender, $recipients, $messages));
    }

    /**
     * @param  string[]  $recipients
     * @param  string[]  $messages
     */
    private function buildMessageBag(string $sender, array $recipients, array $messages): MessageBag
    {
        $bag = new MessageBag();
        $bag->setMessages($this->buildMessageRequests($sender, $recipients, $messages));

        return $bag;
    }

    /**
     * @param  string[]  $recipients
     * @param  string[]  $messages
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

    /**
     * @param  string  $sender
     * @param  array  $recipients
     * @param  string  $message
     *
     * @return Message
     */
    private function buildMessageRequest(string $sender, array $recipients, string $message): Message
    {
        $request = new Message();
        $request->setContent($this->convert($message));
        $request->setTo($recipients);
        $request->setFrom($sender);

        return $request;
    }

    /**
     * @param  MessageBag  $messageBag
     * @return BatchSmsResponse|null
     * @throws SmsSendingException
     */
    private function sendMessages(MessageBag $messageBag): ?BatchSmsResponse
    {
        return $this->smsBatchRepository->sendMessages($messageBag);
    }
}
