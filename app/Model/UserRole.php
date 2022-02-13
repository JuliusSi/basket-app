<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserRole extends Model
{
    protected $table = 'user_role';

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
