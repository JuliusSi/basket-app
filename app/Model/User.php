<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Model
 */
class User extends Authenticatable
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'phone', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * @return bool
     */
    public function isPhoneVerified(): bool
    {
        return (bool)$this->getAttribute('phone_verified_at');
    }

    /**
     * @return HasMany
     */
    public function userAttributes(): HasMany
    {
        return $this->hasMany(UserAttribute::class);
    }

    /**
     * @return HasMany
     */
    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * @return HasMany
     */
    public function courtArrivals(): HasMany
    {
        return $this->hasMany(CourtArrival::class);
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * @param  string  $name
     * @return bool
     */
    public function hasRole(string $name): bool
    {
        foreach ($this->roles()->get() as $role) {
            if ($role->name === $name) {
                return true;
            }
        }

        return false;
    }
}
