<?php

declare(strict_types=1);

namespace App\RadiationChecker\Import\Job;

use App\RadiationChecker\Import\SaveHandler\RadiationDataSaveHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveRadiationData
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(RadiationDataSaveHandler $saveHandler): void
    {
        $saveHandler->save();
    }
}
