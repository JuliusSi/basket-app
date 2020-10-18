<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAttribute
 * @package App\Model
 */
class UserAttribute extends Model
{
    use HasFactory;

    public const ATTRIBUTE_NAME_PHONE_VERIFICATION_ID = 'phone_verification_id';

    /**
     * @var string
     */
    protected $table = 'user_attribute';
}
