<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BasketballCourt
 * @package App\Model
 */
class BasketballCourt extends Model
{
    protected $table = 'basketball_court';

    /**
     * @return BelongsTo
     */
    public function placeCode(): BelongsTo
    {
        return $this->belongsTo(PlaceCode::class);
    }
}
