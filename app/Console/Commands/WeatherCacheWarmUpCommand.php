<?php

namespace App\Console\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Src\Weather\Repository\CachedWeatherRepository;

/**
 * Class WeatherCacheWarmUpCommand
 * @package App\Console\Commands
 */
class WeatherCacheWarmUpCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'weather:warmUpCache';

    /**
     * @var string
     */
    protected $description = 'Warm ups weather cache.';

    /**
     * @var CachedWeatherRepository
     */
    private CachedWeatherRepository $cachedWeatherRepository;

    /**
     * WeatherCacheWarmUpCommand constructor.
     * @param  CachedWeatherRepository  $cachedWeatherRepository
     */
    public function __construct(CachedWeatherRepository $cachedWeatherRepository)
    {
        parent::__construct();
        $this->cachedWeatherRepository = $cachedWeatherRepository;
    }

    /**
     * Execute the console command.
     * @return void
     * @throws GuzzleException
     */
    public function handle(): void
    {
        foreach ($this->getAvailablePlaces() as $placeCode => $placeName) {
            $this->warmUp($placeCode, $placeName);
        }
    }

    /**
     * @param  string  $placeCode
     * @param  string  $placeName
     * @throws GuzzleException
     */
    private function warmUp(string $placeCode, string $placeName): void
    {
        $response = $this->cachedWeatherRepository->find($placeCode);
        if ($response) {
            Log::channel('command')->info(sprintf('Weather cache warm upped for %s place', $placeName));
        } else {
            Log::channel('command')->warning(sprintf('Weather cache not warm upped for %s place', $placeName));
        }
    }

    /**
     * @return string[]
     */
    private function getAvailablePlaces(): array
    {
        return config('weather.available_places');
    }
}
