<?php

namespace Src\Weather\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Src\Weather\Client\Response\Response;

/**
 * Class CachedWeatherRepository
 * @package Src\Weather\Repository
 */
class CachedWeatherRepository extends WeatherRepository
{
    private const DEFAULT_CACHE_KEY_PART = 'meteo-weather';
    private const CACHE_LIFETIME = 1800;

    /**
     * @param  string  $placeCode
     * @return Response|null
     * @throws GuzzleException
     */
    public function find(string $placeCode): ?Response
    {
        $cacheKey = $this->getCacheKey($placeCode);
        if ($cachedResponse = Cache::get($cacheKey)) {
            return $cachedResponse;
        }

        if ($response = parent::find($placeCode)) {
            Cache::put($cacheKey, $response, self::CACHE_LIFETIME);
            return $response;
        }

        return null;
    }

    /**
     * @param  string  $placeCode
     * @return string
     */
    private function getCacheKey(string $placeCode): string
    {
        return self::DEFAULT_CACHE_KEY_PART . '-' . $placeCode;
    }
}
