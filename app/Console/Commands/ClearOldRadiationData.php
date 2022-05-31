<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\RadiationChecker\Model\Radiation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearOldRadiationData extends Command
{
    protected $signature = 'radiation:delete-old-data';

    protected $description = 'Deletes old records from radiation table';

    public function handle(): void
    {
        $recordsCount = $this->deleteRecords();

        if ($recordsCount) {
            $message = sprintf('%s radiation records successfully deleted', $recordsCount);
            $this->info($message);
            Log::channel('command')->info($message);
        } else {
            $this->info('No records to delete.');
        }
    }

    public function deleteRecords(): int
    {
        return Radiation::where('usvph', '<', config('radiation.radiation_background_normal'))
            ->where('created_at', '<=', now()->subMonth()->toDateTimeString())->delete();
    }
}
