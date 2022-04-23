<?php

declare(strict_types=1);

namespace Core\Helpers\Interfaces\Request;

interface StatsAwareRequestInterface
{
    /**
     * @return string[]
     */
    public function getHeaders(): array;

    public function getBody(): string;

    public function getMethod(): string;

    public function getUri(): string;

    public function getQuery(): array;

    public function getConnectionTimeOut(): int;

    public function getOnStats(): callable;
}
