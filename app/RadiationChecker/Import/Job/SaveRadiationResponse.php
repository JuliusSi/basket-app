<?php

declare(strict_types=1);

namespace App\RadiationChecker\Import\Job;

use App\RadiationChecker\Import\SaveHandler\RadiationResponseSaveHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Radiation\Client\Response\Response;

class SaveRadiationResponse implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 2;

    public function __construct(private readonly Response $response)
    {
    }

    public function handle(RadiationResponseSaveHandler $saveHandler): void
    {
        $saveHandler->save($this->response);
    }

    public function tags(): array
    {
        return ['save_radiation_response'];
    }
}
