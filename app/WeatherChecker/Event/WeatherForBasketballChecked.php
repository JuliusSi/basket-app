<?php

declare(strict_types=1);

namespace App\WeatherChecker\Event;

use App\WeatherChecker\Model\Response\WarningResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WeatherForBasketballChecked
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly WarningResponse $response)
    {
    }
}
