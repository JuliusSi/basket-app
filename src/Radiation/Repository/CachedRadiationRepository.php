<?php

declare(strict_types=1);

namespace Src\Radiation\Repository;

use Exception;
use Illuminate\Support\Facades\Cache;
use Src\Radiation\Client\Response\Response;

/**
 * Class CachedRadiationRepository.
 */
class CachedRadiationRepository extends RadiationRepository
{
    private const DEFAULT_CACHE_KEY_PART = 'radiation';
    private const CACHE_LIFETIME = 120; // todo: roll back to 600 then war war in u

    /**
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
