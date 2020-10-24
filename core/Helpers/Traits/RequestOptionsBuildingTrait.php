<?php

namespace Core\Helpers\Traits;

use GuzzleHttp\RequestOptions;
use Src\Sms\Client\Request\RequestInterface;

/**
 * Trait RequestOptionsBuildingTrait
 * @package Core\Helpers\Traits
 */
trait RequestOptionsBuildingTrait
{
    /**
     * @param  RequestInterface  $request
     * @return array
     */
    private function buildOptions(RequestInterface $request): array
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
        $options[RequestOptions::ON_STATS] = $request->getOnStats();

        return $options;
    }
}
