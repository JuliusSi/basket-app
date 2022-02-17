<?php

declare(strict_types=1);

namespace App\Console\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Src\Weather\Repository\CachedWeatherRepository;

/**
 * Class WeatherCacheWarmUpCommand.
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

    private CachedWeatherRepository $cachedWeatherRepository;

    /**
     * WeatherCacheWarmUpCommand constructor.
     */
    public function __construct(CachedWeatherRepository $cachedWeatherRepository)
    {
        parent::__construct();
        $this->cachedWeatherRepository = $cachedWeatherRepository;
    }

    /**
     * Execute the console command.
     *
     * @throws GuzzleException
     */
    public function handle(): void
    {
        foreach ($this->getAvailablePlaces() as $placeCode => $placeName) {
            $this->warmUp($placeCode, $placeName);
        }
    }

    /**
     * @throws GuzzleException
     */
    private function warmUp(string $placeCode, string $placeName): void
    {
        $response = $this->cachedWeatherRepository->find($placeCode);
        if ($response) {
            $message = sprintf(
                'Weather cache warm upped for %s place. Forecast created: %s.',
                $placeName,
                $response->getForecastCreationTimeUtc()
            );
            Log::channel('command')->info($message);
            $this->info($message);
        } else {
            Log::channel('command')->warning(sprintf('Weather cache not warm upped for %s place.', $placeName));
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
