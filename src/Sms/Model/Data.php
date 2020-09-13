<?php

namespace Src\Sms\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Data
 * @package Src\Sms\Model
 */
class Data
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("batchId")
     */
    private string $batchId;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("messageCount")
     */
    private string $messageCount;

    /**
     * @return string
     */
    public function getBatchId(): string
    {
        return $this->batchId;
    }

    /**
     * @param  string  $batchId
     */
    public function setBatchId(string $batchId): void
    {
        $this->batchId = $batchId;
    }

    /**
     * @return string
     */
    public function getMessageCount(): string
    {
        return $this->messageCount;
    }

    /**
     * @param  string  $messageCount
     */
    public function setMessageCount(string $messageCount): void
    {
        $this->messageCount = $messageCount;
    }
}
