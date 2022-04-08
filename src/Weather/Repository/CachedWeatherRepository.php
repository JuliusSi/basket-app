<?php

declare(strict_types=1);

namespace Src\Weather\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Src\Weather\Client\Response\Response;

class CachedWeatherRepository extends WeatherRepository
{
    private const DEFAULT_CACHE_KEY_PART = 'meteo-weather';
    private const CACHE_LIFETIME = 600;

    /**
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

    private function getCacheKey(string $placeCode): string
    {
        return self::DEFAULT_CACHE_KEY_PART.'-'.$placeCode;
    }
}
