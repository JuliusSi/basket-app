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
            $message = sprintf('Transfer time: %s, Uri: %s.', $stats->getTransferTime(), $stats->getEffectiveUri());
            Log::channel('client')->info($message);
        };
    }
}
