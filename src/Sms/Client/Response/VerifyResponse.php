<?php

namespace Src\Sms\Client\Response;

use JMS\Serializer\Annotation as JMS;

/**
 * Class VerifyResponse
 * @package Src\Sms\Client\Response
 */
class VerifyResponse
{
    public const STATUS_SUCCESS = 'success';

    /**
     * @JMS\Type("string")
     * @var string
     */
    private string $status;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param  string  $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }
}
