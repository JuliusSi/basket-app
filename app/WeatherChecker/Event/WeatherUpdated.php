<?php

declare(strict_types=1);

namespace App\WeatherChecker\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Weather\Client\Response\Response;

class WeatherUpdated
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Response $response)
    {
    }
}
