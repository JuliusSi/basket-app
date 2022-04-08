<?php

declare(strict_types=1);

namespace Src\Radiation\Repository;

use Exception;
use Illuminate\Support\Facades\Cache;
use Src\Radiation\Client\Response\Response;

class CachedRadiationRepository extends RadiationRepository
{
    private const DEFAULT_CACHE_KEY_PART = 'radiation';
    private const CACHE_LIFE_TIME = 120; // todo: roll back to 600 then war ends

    /**
     * @throws Exception
     */
    public function find(): Response
    {
        return Cache::remember(
            self::DEFAULT_CACHE_KEY_PART,
            self::CACHE_LIFE_TIME,
            function () {
                return parent::find();
            }
        );
    }
}
