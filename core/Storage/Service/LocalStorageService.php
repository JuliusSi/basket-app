<?php

declare(strict_types=1);

namespace Core\Storage\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LocalStorageService
{
    public const DIRECTORY_MEMES = 'memes';
    public const DIRECTORY_RANDOM = 'random';
    public const DIRECTORY_COURTS = 'courts';

    public function __construct(private Storage $storage)
    {
    }

    public function findFileUrl(string $fileName, string $directory, string $disk = 'public'): ?string
    {
        $path = $this->getPath($fileName, $directory, $disk);
        if ($this->storage::exists($path)) {
            return asset($this->storage::url($path));
        }

        Log::warning(sprintf('File %s not found', $fileName));

        return null;
    }

    public function findAllDirectoryFiles(string $directory): array
    {
        return $this->storage::allFiles($directory);
    }

    private function getPath(string $fileName, string $directory, string $disk): string
    {
        return sprintf('%s/%s/%s', $disk, $directory, $fileName);
    }
}
