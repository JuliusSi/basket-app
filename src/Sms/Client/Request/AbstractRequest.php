<?php

namespace Src\Sms\Client\Request;

use Core\Helpers\Traits\SerializationTrait;

/**
 * Class DefaultRequest
 * @package Src\Sms\Client\Request
 */
abstract class AbstractRequest implements RequestInterface
{
    use SerializationTrait;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'POST';
    }
}
