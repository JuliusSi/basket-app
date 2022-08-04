<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string username
 * @property int sms
 */
class User extends Authenticatable
{
    public const STATUS_ADMINISTRATOR = 'administrator';

    use HasFactory;

    protected $table = 'user';

    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'api_token',
        'last_login_at',
    ];

    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function isPhoneVerified(): bool
    {
        return (bool) $this->getAttribute('phone_verified_at');
    }

    public function userAttributes(): HasMany
    {
        return $this->hasMany(UserAttribute::class);
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function hasRole(string $name): bool
    {
        foreach ($this->roles()->get() as $role) {
            if ($role->name === $name) {
                return true;
            }
        }

        return false;
    }

    public function getUserAttributeValueByName(string $name): ?string
    {
        foreach ($this->userAttributes()->get() as $attribute) {
            if ($attribute->name === $name) {
                return $attribute->value;
            }
        }

        return null;
    }

    public function isAdministrator(): bool
    {
        return self::STATUS_ADMINISTRATOR === $this->getAttribute('status');
    }
}
