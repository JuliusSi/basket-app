<?php

namespace Src\Weather\Client\Request;

use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Log;

/**
 * Class AbstractRequest
 * @package Src\Weather\Client\Request
 */
class AbstractRequest implements RequestInterface
{
    protected const DEFAULT_CONNECTION_TIMEOUT = 2;

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
       return [];
    }


    /**
     * @return string
     */
    public function getBody(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return [];
    }

    /**
     * @return int
     */
    public function getConnectionTimeOut(): int
    {
        return self::DEFAULT_CONNECTION_TIMEOUT;
    }

    /**
     * @return callable
     */
    public function getOnStats(): callable
    {
        return static function (TransferStats $stats)
        {
            Log::info(sprintf('Transfer time: %s, Uri: %s.', $stats->getTransferTime(), $stats->getEffectiveUri()));
        };
    }
}
