<?php

declare(strict_types=1);

namespace Src\Weather\Client\Request;

use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Log;

/**
 * Class AbstractRequest.
 */
class AbstractRequest implements RequestInterface
{
    protected const DEFAULT_CONNECTION_TIMEOUT = 5;

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [];
    }

    public function getBody(): string
    {
        return '';
    }

    public function getMethod(): string
    {
        return '';
    }

    public function getUri(): string
    {
        return '';
    }

    public function getQuery(): array
    {
        return [];
    }

    public function getConnectionTimeOut(): int
    {
        return self::DEFAULT_CONNECTION_TIMEOUT;
    }

    public function getOnStats(): callable
    {
        return static function (TransferStats $stats) {
            $message = sprintf('Transfer time: %s, Uri: %s.', $stats->getTransferTime(), $stats->getEffectiveUri());
            Log::channel('client')->info($message);
        };
    }
}
