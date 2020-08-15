<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

/**
 * Class LogsClearCommand
 * @package App\Console\Commands
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
     *
     * @var Filesystem
     */
    private Filesystem $disk;

    /**
     * Create a new command instance.
     *
     * @param  Filesystem  $disk
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

    /**
     * @param  int  $flushedFilesCount
     */
    private function addFlushInfo(int $flushedFilesCount): void
    {
        if (!$flushedFilesCount) {
            $this->info('There was no log file to delete in the log folder');
        } elseif ($flushedFilesCount === 1) {
            $this->info('1 log file has been deleted');
        } else {
            $this->info($flushedFilesCount . ' log files have been deleted');
        }
    }

    /**
     * @return Collection
     */
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

    /**
     * @param Collection $files
     * @return int
     */
    private function flushLogs(Collection $files): int
    {
        return $files->each(function ($file) {
            $this->disk->delete($file);
        })->count();
    }
}
