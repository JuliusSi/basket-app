<?php

namespace Core\Storage\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class LocalStorageService
 * @package Core\Storage\Service
 */
class LocalStorageService
{
    public const DIRECTORY_MEMES = 'memes';
    public const DIRECTORY_RANDOM = 'random';

    /**
     * @var Storage
     */
    private Storage $storage;

    /**
     * LocalStorageService constructor.
     * @param  Storage  $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param  string  $fileName
     * @param  string  $directory
     * @param  string  $disk
     * @return string|null
     */
    public function findFileUrl(string $fileName, string $directory, string $disk = 'public'): ?string
    {
        $path = $this->getPath($fileName, $directory, $disk);
        if ($this->storage::exists($path)) {
            return asset($this->storage::url($path));
        }

        Log::warning(sprintf('File %s not found', $fileName));
        return null;
    }

    /**
     * @param  string  $directory
     * @return array
     */
    public function findAllDirectoryFiles(string $directory): array
    {
        return $this->storage::allFiles($directory);
    }

    /**
     * @param  string  $fileName
     * @param  string  $directory
     * @param  string  $disk
     * @return string
     */
    private function getPath(string $fileName, string $directory, string $disk): string
    {
        return sprintf('%s/%s/%s', $disk, $directory, $fileName);
    }
}
