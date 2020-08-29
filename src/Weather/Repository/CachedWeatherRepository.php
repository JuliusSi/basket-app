<?php

namespace Src\Weather\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Src\Weather\Client\Request\DefaultRequest;
use Src\Weather\Client\Response\Response;

/**
 * Class CachedWeatherRepository
 * @package Src\Weather\Repository
 */
class CachedWeatherRepository extends WeatherRepository
{
    private const DEFAULT_CACHE_KEY_PART = 'meteo-weather';
    private const CACHE_LIFETIME = 3600;

    /**
     * @param  DefaultRequest  $request
     * @return Response|null
     * @throws GuzzleException
     */
    public function find(DefaultRequest $request): ?Response
    {
        $cacheKey = $this->getCacheKey($request);
        if ($cachedResponse = Cache::get($cacheKey)) {
            return $cachedResponse;
        }

        if ($response = parent::find($request)) {
            Cache::put($cacheKey, $response, self::CACHE_LIFETIME);
            return $response;
        }

        return null;
    }

    /**
     * @param  DefaultRequest  $request
     * @return string
     */
    private function getCacheKey(DefaultRequest $request): string
    {
        return self::DEFAULT_CACHE_KEY_PART . '-' . $request->getPlace();
    }
}
