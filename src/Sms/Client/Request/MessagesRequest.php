<?php

namespace Src\Sms\Client\Request;

use Src\Sms\Model\MessageBag;

/**
 * Class MessagesRequest
 * @package Src\Sms\Client\Request
 */
class MessagesRequest extends AbstractRequest
{
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

    /**
     * @return string
     */
    public function getUri(): string
    {
        return config('provider.d7sms_rapid_send_batch_api_endpoint');
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [
            'Authorization' => 'Basic ' . config('provider.d7sms_rapid_sms_api_token'),
            'x-rapidapi-host' => config('provider.d7sms_rapid_api_host'),
            'x-rapidapi-key' => config('provider.d7sms_rapid_api_key'),
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->serialize($this->getMessageBag());
    }
}
