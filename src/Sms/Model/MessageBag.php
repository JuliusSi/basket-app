<?php

namespace Src\Sms\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class MessageBag
 * @package Src\Sms\Model
 */
class MessageBag
{
    /**
     * @JMS\Type("array<Src\Sms\Model\Message>")
     * @JMS\SerializedName("messages")
     *
     * @var Message[] $messages
     */
    private array $messages;

    /**
     * @return Message[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param  Message[]  $messages
     */
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }
}
