<?php

namespace App\RadiationChecker\Resolver;

use App\RadiationChecker\Model\RadiationInfo;

/**
 * Class RadiationStatusResolver
 * @package App\RadiationChecker\Resolver
 */
class RadiationStatusResolver
{
    /**
     * @param  string  $microsievert
     * @return string
     */
    public function resolve(string $microsievert): string
    {
        return match (true) {
            $microsievert < config('radiation.radiation_background_normal') => RadiationInfo::STATUS_CODE_NORMAL,
            $microsievert < config('radiation.radiation_background_high') => RadiationInfo::STATUS_CODE_HIGH,
            $microsievert > config('radiation.radiation_background_high') => RadiationInfo::STATUS_CODE_DANGER,
            default => 'undefined',
        };
    }
}
