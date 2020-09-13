<?php

namespace Src\Sms\Client\Request;

use Src\Sms\Client\Traits\SerializationTrait;
use Src\Sms\Model\MessageBag;

/**
 * Class MessagesRequest
 * @package Src\Sms\Client\Request
 */
class MessagesRequest extends AbstractRequest
{
    use SerializationTrait;

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->serialize($this->getMessageBag());
    }

    /**
     * @var MessageBag $messageBag
     */
    private MessageBag $messageBag;

    /**
     * @return MessageBag
     */
    public function getMessageBag(): MessageBag
    {
        return $this->messageBag;
    }

    /**
     * @param  MessageBag  $messageBag
     */
    public function setMessageBag(MessageBag $messageBag): void
    {
        $this->messageBag = $messageBag;
    }
}
