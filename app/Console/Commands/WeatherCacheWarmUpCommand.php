<?php

namespace App\Console\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Request\DefaultRequest;
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
     * @return bool
     * @throws GuzzleException
     */
    public function handle(): bool
    {
        foreach (CachedWeatherRepository::AVAILABLE_PLACE_CODES as $place) {
            $request = $this->buildRequest($place);
            if ($response = $this->cachedWeatherRepository->find($request)) {
                Log::info(sprintf('Weather cache warm upped for %s place', $request->getPlace()));
                return true;
            }
        }

        return false;
    }

    /**
     * @param  string  $place
     * @return DefaultRequest
     */
    private function buildRequest(string $place): DefaultRequest
    {
        $request = new DefaultRequest();
        $request->setPlace($place);

        return $request;
    }
}
