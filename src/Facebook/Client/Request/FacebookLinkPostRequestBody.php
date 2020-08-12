<?php

namespace Src\Facebook\Client\Request;

use JMS\Serializer\Annotation as JMS;

/**
 * Class FacebookLinkPostRequestBody
 * @package Src\Facebook\Client\Request
 */
class FacebookLinkPostRequestBody
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("link")
     */
    private string $link;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("message")
     */
    private string $message;

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param  string  $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param  string  $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
