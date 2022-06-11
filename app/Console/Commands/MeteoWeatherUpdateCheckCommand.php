<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Src\Weather\Event\WeatherUpdated;
use Src\Weather\Repository\WeatherRepository;

class MeteoWeatherUpdateCheckCommand extends Command
{
    protected $signature = 'weather:meteo-weather-update-check';

    protected $description = 'Checks is weather updated';

    public function handle(WeatherRepository $weatherRepository): void
    {
        $this->info('Checking for weather update..');

        foreach ($this->getAvailablePlaces() as $placeCode => $placeName) {
            $cacheKey = 'meteo_last_update_'.$placeCode;
            $lastUpdate = Cache::get($cacheKey);

            try {
                $response = $weatherRepository->find($placeCode);
            } catch (Exception|GuzzleException $exception) {
                $this->error($exception->getMessage());

                continue;
            }

            if (!$response) {
                $this->error('No response for place code: '.$placeCode);

                continue;
            }

            if ($lastUpdate !== $response->getForecastCreationTimeUtc()) {
                $this->info(sprintf('Weather updated for place: %s, %s', $placeName, $response->getForecastCreationTimeUtc()));
                Cache::put($cacheKey, $response->getForecastCreationTimeUtc());
                WeatherUpdated::dispatch($response);
            } else {
                $this->info(sprintf('No updates for place: %s, last update: %s', $placeName, $lastUpdate));
            }
        }

        $this->info('Weather update checking ended.');
    }

    /**
     * @return string[]
     */
    private function getAvailablePlaces(): array
    {
        return config('weather.available_places');
    }
}
