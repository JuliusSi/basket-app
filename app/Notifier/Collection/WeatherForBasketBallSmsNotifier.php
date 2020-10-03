<?php

namespace App\Notifier\Collection;

use App\Helpers\Traits\LithuanianLetterConverter;
use App\Notifier\Model\Notification;
use Exception;
use Src\Sms\Client\Request\MessagesRequest;
use Src\Sms\Client\Response\Response;
use Src\Sms\Model\Message;
use Src\Sms\Model\MessageBag;
use Src\Sms\Repository\SmsBatchRepository;

/**
 * Class WeatherForBasketBallSmsNotifier
 * @package App\Notifier\Collection
 */
class WeatherForBasketBallSmsNotifier implements NotifierInterface
{
    use LithuanianLetterConverter;

    /**
     * @var SmsBatchRepository
     */
    private SmsBatchRepository $repository;

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
        $request = $this->buildRequest($notifications);

        $this->sendMessages($request);
    }

    /**
     * @param  Notification[]  $notifications
     * @return MessagesRequest
     */
    private function buildRequest(array $notifications): MessagesRequest
    {
        $request = new MessagesRequest();
        $request->setMessageBag($this->buildMessageBag($notifications));

        return $request;
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
     * @param  MessagesRequest  $request
     * @return Response|null
     */
    private function sendMessages(MessagesRequest $request): ?Response
    {
        try {
            return $this->repository->sendMessages($request);
        } catch (Exception $exception) {
            return null;
        }
    }
}
