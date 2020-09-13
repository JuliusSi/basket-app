<?php

namespace Src\Sms\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Message
 * @package Src\Sms\Model
 */
class Message
{
    /**
     * @JMS\Type("string")
     * @var string
     */
    private string $content;

    /**
     * @JMS\Type("string")
     * @var string
     */
    private string $from;

    /**
     * @JMS\Type("array<string>")
     * @var array
     */
    private array $to;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param  string  $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param  string  $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @param  array  $to
     */
    public function setTo(array $to): void
    {
        $this->to = $to;
    }
}
