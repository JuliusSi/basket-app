<?php

namespace App\Notifier\Collection;

use Core\Helpers\Traits\StringToBinaryConverter;
use App\Notifier\Model\Notification;
use Exception;
use Src\Sms\Client\Response\BatchSmsResponse;
use Src\Sms\Model\Message;
use Src\Sms\Model\MessageBag;
use Src\Sms\Repository\SmsBatchRepository;

/**
 * Class SmsNotifier
 * @package App\Notifier\Collection
 */
class SmsNotifier implements NotifierInterface
{
    use StringToBinaryConverter;

    /**
     * @var SmsBatchRepository
     */
    private SmsBatchRepository $repository;

    /**
     * SmsNotifier constructor.
     * @param  SmsBatchRepository  $repository
     */
    public function __construct(SmsBatchRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param  Notification[]  $notifications
     * @return void
     */
    public function notify(array $notifications): void
    {
        $this->sendMessages($this->buildMessageBag($notifications));
    }


    /**
     * @param  Notification[]  $notifications
     * @return MessageBag
     */
    private function buildMessageBag(array $notifications): MessageBag
    {
        $bag = new MessageBag();
        $bag->setMessages($this->buildMessageRequests($notifications));

        return $bag;
    }

    /**
     * @param  Notification[]  $notifications
     * @return Message[]
     */
    private function buildMessageRequests(array $notifications): array
    {
        $messageRequests = [];
        foreach ($notifications as $notification) {
            $messageRequests[] = $this->buildMessageRequest($notification);
        }

        return $messageRequests;
    }

    /**
     * @param  Notification  $notification
     * @return Message
     */
    private function buildMessageRequest(Notification $notification): Message
    {
        $request = new Message();
        $request->setContent($this->convert($notification->getContent()));
        $request->setTo($notification->getSmsRecipients());
        $request->setFrom(config('sms.sender_name'));

        return $request;
    }

    /**
     * @param  MessageBag  $messageBag
     * @return BatchSmsResponse|null
     */
    private function sendMessages(MessageBag $messageBag): ?BatchSmsResponse
    {
        try {
            return $this->repository->sendMessages($messageBag);
        } catch (Exception $exception) {
            return null;
        }
    }
}
