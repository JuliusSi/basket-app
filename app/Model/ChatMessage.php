<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ChatMessage
 * @package App\Model
 */
class ChatMessage extends Model
{
    protected $fillable = ['message'];

    /**
     * @var string
     */
    protected $table = 'chat_message';

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
