<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BasketballCourt.
 */
class BasketballCourt extends Model
{
    protected $table = 'basketball_court';

    protected $hidden = ['placeCode'];

    public function placeCode(): BelongsTo
    {
        return $this->belongsTo(PlaceCode::class);
    }
}
