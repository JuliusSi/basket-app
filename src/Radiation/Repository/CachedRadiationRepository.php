<?php

namespace Src\Radiation\Repository;

use Exception;
use Illuminate\Support\Facades\Cache;
use Src\Radiation\Client\Response\Response;

/**
 * Class CachedRadiationRepository
 * @package Src\Radiation\Repository
 */
class CachedRadiationRepository extends RadiationRepository
{
    private const DEFAULT_CACHE_KEY_PART = 'radiation';
    private const CACHE_LIFETIME = 600;

    /**
     * @return Response
     * @throws Exception
     */
    public function find(): Response
    {
        $cacheKey = self::DEFAULT_CACHE_KEY_PART;
        if ($cachedResponse = Cache::get($cacheKey)) {
            return $cachedResponse;
        }

        $response = parent::find();
        Cache::put($cacheKey, $response, self::CACHE_LIFETIME);

        return $response;
    }
}
