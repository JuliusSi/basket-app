<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class BasketballCourt
 * @package App\Model
 */
class BasketballCourt extends Model
{
    protected $table = 'basketball_court';

    protected $hidden = ['arrivals', 'placeCode'];

    /**
     * @return BelongsTo
     */
    public function placeCode(): BelongsTo
    {
        return $this->belongsTo(PlaceCode::class);
    }

    /**
     * @return HasMany
     */
    public function arrivals(): HasMany
    {
        return $this->hasMany(CourtArrival::class, 'court_id');
    }
}
