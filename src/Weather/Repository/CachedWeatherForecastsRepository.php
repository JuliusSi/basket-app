<?php

declare(strict_types=1);

namespace Src\Weather\Repository;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Src\Weather\Client\Response\Response;

class CachedWeatherForecastsRepository extends WeatherForecastsRepository
{
    private const DEFAULT_CACHE_KEY_PART = 'weather_forecasts';
    private const CACHE_LIFE_TIME = 3600;

    /**
     * @throws GuzzleException
     */
    public function find(string $placeCode): ?Response
    {
        return Cache::remember(
            $this->getCacheKey($placeCode),
            self::CACHE_LIFE_TIME,
            function () use ($placeCode) {
                return parent::find($placeCode);
            }
        );
    }

    /**
     * @throws GuzzleException
     */
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
