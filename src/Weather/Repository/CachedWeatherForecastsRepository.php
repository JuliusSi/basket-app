<?php

declare(strict_types=1);

namespace Src\Weather\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Src\Weather\Client\Response\Response;

class CachedWeatherForecastsRepository extends WeatherForecastsRepository
{
    private const DEFAULT_CACHE_KEY_PART = 'weather_forecasts';
    private const CACHE_LIFETIME = 3600;

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

    public function refreshCache(string $placeCode): void
    {
        Cache::forget($this->getCacheKey($placeCode));
        $this->find($placeCode);
    }

    private function getCacheKey(string $placeCode): string
    {
        return self::DEFAULT_CACHE_KEY_PART.'_'.$placeCode;
    }
}
