<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int         $user_id
 * @property string      $sku
 * @property int         $quantity
 * @property string      $payment_id
 * @property null|string $payer_id
 * @property null|string $payer_email
 * @property float       $amount
 * @property string      $currency
 * @property string      $status
 * @property User        $user
 */
class Payment extends Model
{
    public const STATUS_APPROVED = 'approved';
    public const STATUS_CREATED = 'created';

    protected $fillable = [
        'sku',
        'quantity',
        'payment_id',
        'payer_id',
        'payer_email',
        'amount',
        'currency',
        'status',
    ];

    /**
     * @var string
     */
    protected $table = 'payment';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
