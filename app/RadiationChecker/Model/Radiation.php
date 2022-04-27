<?php

declare(strict_types=1);

namespace App\RadiationChecker\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $meter
 * @property $status
 * @property $usvph
 * @property $measured_at
 */
class Radiation extends Model
{
    protected $table = 'radiation';
}
