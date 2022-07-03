<?php

declare(strict_types=1);

namespace App\WeatherChecker\Repository;

use App\WeatherChecker\Model\Response\WeatherResponse;
use Carbon\CarbonInterface;
use Exception;
use Illuminate\Support\Facades\Cache;

class CachedWeatherRepository extends WeatherRepository
{
    private const CACHE_LIFE_TIME = 600;

    public function find(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): WeatherResponse
    {
        return Cache::remember(
            $this->getCacheKey($placeCode, $startDate, $endDate),
            self::CACHE_LIFE_TIME,
            function () use ($placeCode, $startDate, $endDate) {
                return parent::find($placeCode, $startDate, $endDate);
            }
        );
    }

    /**
     * @throws Exception
     */
    public function refreshCache(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): void
    {
        Cache::forget($this->getCacheKey($placeCode, $startDate, $endDate));
        $this->find($placeCode, $startDate, $endDate);
    }

    private function getCacheKey(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): string
    {
        return sprintf(
            '%s_%s_%s',
            $placeCode,
            $startDate->format('Y-m-d H'),
            $endDate->format('Y-m-d H')
        );
    }
}
