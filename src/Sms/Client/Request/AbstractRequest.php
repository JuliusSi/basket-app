<?php

namespace Src\Sms\Client\Request;

use Core\Helpers\Traits\SerializationTrait;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Log;
use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface;

/**
 * Class DefaultRequest
 * @package Src\Sms\Client\Request
 */
abstract class AbstractRequest implements StatsAwareRequestInterface
{
    use SerializationTrait;

    protected const DEFAULT_CONNECTION_TIMEOUT = 2;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return int
     */
    public function getConnectionTimeOut(): int
    {
        return self::DEFAULT_CONNECTION_TIMEOUT;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return [];
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
