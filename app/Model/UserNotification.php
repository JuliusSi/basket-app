<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotification extends Model
{
    public const STATUS_NEW = 'new';
    public const STATUS_READ = 'read';

    protected $fillable = ['status', 'name', 'description'];

    /**
     * @var string
     */
    protected $table = 'user_notification';

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
