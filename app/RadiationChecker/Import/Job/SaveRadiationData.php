<?php

declare(strict_types=1);

namespace App\RadiationChecker\Import\Job;

use App\RadiationChecker\Import\SaveHandler\RadiationDataSaveHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SaveRadiationData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(RadiationDataSaveHandler $saveHandler): void
    {
        Log::channel('queue')->info('Job started.', ['class' => __CLASS__]);

        $saveHandler->save();

        Log::channel('queue')->info('Job finished.', ['class' => __CLASS__]);
    }
}
