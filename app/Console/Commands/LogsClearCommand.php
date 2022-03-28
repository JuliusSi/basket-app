<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

/**
 * Class LogsClearCommand.
 */
class LogsClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear {--keep-last : Whether the last log file should be kept}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove every log files in the log directory';

    /**
     * A filesystem instance.
     */
    private Filesystem $disk;

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $disk)
    {
        parent::__construct();
        $this->disk = $disk;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $files = $this->getLogFiles();
        $flushedFilesCount = $this->flushLogs($files);

        $this->addFlushInfo($flushedFilesCount);
    }

    private function addFlushInfo(int $flushedFilesCount): void
    {
        if (!$flushedFilesCount) {
            $this->info('There was no log file to delete in the log folder');
        } elseif (1 === $flushedFilesCount) {
            $this->info('1 log file has been deleted');
        } else {
            $this->info($flushedFilesCount.' log files have been deleted');
        }
    }

    private function getLogFiles(): Collection
    {
        $files = collect(
            $this->disk->allFiles(storage_path('logs'))
        )->sortBy('mtime');

        if ($this->option('keep-last') && $files->count() >= 1) {
            $files->shift();
        }

        return $files;
    }

    private function flushLogs(Collection $files): int
    {
        return $files->each(function ($file) {
            $this->disk->delete($file);
        })->count();
    }
}
