<?php

namespace Src\Sms\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Message
 * @package Src\Sms\Model
 */
class Message
{
    public const CODING_8 = 8;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("hex_content")
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
     * @JMS\Type("integer")
     * @var int
     */
    private int $coding = self::CODING_8;

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

    /**
     * @return int
     */
    public function getCoding(): int
    {
        return $this->coding;
    }

    /**
     * @param  int  $coding
     */
    public function setCoding(int $coding): void
    {
        $this->coding = $coding;
    }
}
