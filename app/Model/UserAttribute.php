<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttribute extends Model
{
    use HasFactory;

    public const NAME_PHONE_VERIFICATION_ID = 'phone_verification_id';
    public const NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_PLACE_CODE = 'weather_for_basketball_notification_place_code';
    public const NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_TIME = 'weather_for_basketball_notification_time';
    public const NAME_NOTIFY_ABOUT_WEATHER_FOR_BASKETBALL = 'notify_about_weather_for_basketball_by_sms';

    public const VALUE_TRUE = '1';
    public const VALUE_TIME_TO_NOTIFY_ABOUT_WEATHER_FOR_BASKETBALL = '15:00';

    /**
     * @var string
     */
    protected $table = 'user_attribute';

    protected $fillable = [
        'name',
        'value',
    ];
}
