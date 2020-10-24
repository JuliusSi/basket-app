<?php

namespace Core\Helpers\Interfaces\Request;

/**
 * Interface RequestInterface
 * @package Core\Helpers\Interfaces\Request
 */
interface StatsAwareRequestInterface
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

    /**
     * @return array
     */
    public function getQuery(): array;

    /**
     * @return int
     */
    public function getConnectionTimeOut(): int;

    /**
     * @return callable
     */
    public function getOnStats(): callable;
}
