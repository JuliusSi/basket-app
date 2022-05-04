<?php

declare(strict_types=1);

namespace App\RadiationChecker\Model;

use Illuminate\Database\Eloquent\Model;
use Src\Radiation\Repository\GolfCharlieRepository;
use Src\Radiation\Repository\RadiationRepository;

/**
 * @property $meter
 * @property $status
 * @property $usvph
 * @property $measured_at
 */
class Radiation extends Model
{
    public const AVAILABLE_METERS = [
        RadiationRepository::METER_NAME,
        GolfCharlieRepository::METER_NAME,
    ];

    protected $table = 'radiation';
}
