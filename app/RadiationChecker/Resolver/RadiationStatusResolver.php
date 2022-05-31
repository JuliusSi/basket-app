<?php

declare(strict_types=1);

namespace App\RadiationChecker\Resolver;

use App\RadiationChecker\Model\RadiationInfo;

class RadiationStatusResolver
{
    public function resolve(float $microsievert): string
    {
        return match (true) {
            $microsievert < config('radiation.radiation_background_low') => RadiationInfo::STATUS_LOW,
            $microsievert < config('radiation.radiation_background_normal') => RadiationInfo::STATUS_NORMAL,
            $microsievert < config('radiation.radiation_background_high') => RadiationInfo::STATUS_HIGH,
            $microsievert > config('radiation.radiation_background_high') => RadiationInfo::STATUS_DANGER,
            default => 'undefined',
        };
    }
}
