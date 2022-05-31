<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Core\Logger\Event\ActionDone;
use Core\Logger\Model\Log;
use Core\Logger\Repository\DatabaseRepository;
use Illuminate\Console\Command;
use Psr\Log\LogLevel;

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
        event(new ActionDone($this->getLog()));
    }

    public function getLog(): Log
    {
        return Log::create(
            message: '<b>{username}</b>: old actions deleted.',
            context: ['username' => config('seeder.user.username')],
            level: LogLevel::ALERT,
        );
    }
}
