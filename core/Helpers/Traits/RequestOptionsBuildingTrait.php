<?php

declare(strict_types=1);

namespace Core\Helpers\Traits;

use GuzzleHttp\RequestOptions;
use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface;

/**
 * Trait RequestOptionsBuildingTrait
 * @package Core\Helpers\Traits
 */
trait RequestOptionsBuildingTrait
{
    /**
     * @param  StatsAwareRequestInterface  $request
     * @return array
     */
    private function buildOptions(StatsAwareRequestInterface $request): array
    {
        $options = [];
        if ($headers = $request->getHeaders()) {
            $options[RequestOptions::HEADERS] = $headers;
        }
        if ($body = $request->getBody()) {
            $options[RequestOptions::BODY] = $body;
        }
        if ($timeOut = $request->getConnectionTimeOut()) {
            $options[RequestOptions::CONNECT_TIMEOUT] = $timeOut;
        }
        if ($query = $request->getQuery()) {
            $options[RequestOptions::QUERY] = $query;
        }
        $options[RequestOptions::ON_STATS] = $request->getOnStats();

        return $options;
    }
}
