<?php

namespace Src\Sms\Client\Request;

/**
 * Interface RequestInterface
 * @package Src\Sms\Client\Request
 */
interface RequestInterface
{
    /**
     * @return string[]
     */
    public function getHeaders(): array;

    /**
     * @return string
     */
    public function getBody(): string;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getUri(): string;
}
