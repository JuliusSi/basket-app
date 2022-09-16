<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Core\Logger\Repository\DatabaseRepository;
use Illuminate\Console\Command;

class LogTableDeleteOldCommand extends Command
{
    protected $signature = 'log-table:delete-old';

    protected $description = 'Deletes old records from log table';

    public function __construct(private readonly DatabaseRepository $repository)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('Starting to clear old records');
        $this->repository->deleteOlderThenDate(Carbon::now()->subMonths(3)->toDateTime());
        $this->info('Records have been deleted.');
    }
}
