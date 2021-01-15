<?php

namespace Src\Radiation\Client\Request;

use Core\Helpers\Traits\SerializationTrait;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Log;
use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface;

/**
 * Class AbstractRequest
 * @package Src\Radiation\Client\Request
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
        return 'GET';
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
            $message = sprintf('Transfer time: %s, Uri: %s.', $stats->getTransferTime(), $stats->getEffectiveUri());
            Log::channel('client')->info($message);
        };
    }
}
