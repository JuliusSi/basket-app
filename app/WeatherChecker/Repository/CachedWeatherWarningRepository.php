<?php

declare(strict_types=1);

namespace App\WeatherChecker\Repository;

use App\WeatherChecker\Model\Response\WarningResponse;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Cache;

class CachedWeatherWarningRepository extends WeatherWarningRepository
{
    private const CACHE_LIFE_TIME = 600;

    public function find(string $placeCode, CarbonInterface $startDate, CarbonInterface $endDate): WarningResponse
    {
        return Cache::remember(
            $this->getCacheKey($placeCode, $startDate, $endDate),
            self::CACHE_LIFE_TIME,
            function () use ($placeCode, $startDate, $endDate) {
                return parent::find($placeCode, $startDate, $endDate);
            }
        );
    }

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
