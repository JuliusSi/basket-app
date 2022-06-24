<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\WeatherChecker\Event\WeatherUpdated;
use Src\Weather\Repository\WeatherRepository;

class WeatherUpdateCheckCommand extends Command
{
    protected $signature = 'weather:update-check';

    protected $description = 'Checks for weather updates';

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

            $date = Carbon::instance($response->getForecastCreationTimeUtc());
            if (!$date->isToday()) {
                $this->warn('Weather not updated today. Last update: '.$date->toDateString());

                continue;
            }

            if ($lastUpdate !== $response->getForecastCreationTimeUtc()->format('Y-m-d H:i')) {
                $this->info(sprintf('Weather updated for place: %s, %s', $placeName, $response->getForecastCreationTimeUtc()->format('Y-m-d H:i')));
                Cache::put($cacheKey, $response->getForecastCreationTimeUtc()->format('Y-m-d H:i'));
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
