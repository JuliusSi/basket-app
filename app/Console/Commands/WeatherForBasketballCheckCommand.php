<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\WeatherChecker\Event\WeatherForBasketballChecked;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Response\WeatherResponse;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class WeatherForBasketballCheckCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'weather:check-weather-for-basketball {placeCode? : Place code} {from? : Date from} {to? : Date to}';

    /**
     * @var string
     */
    protected $description = 'Notifies about weather for basketball.';

    public function __construct(private readonly WeatherCheckManager $manager)
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        if (!$this->canHandle()) {
            $message = sprintf('Command %s is not executed due to configuration.', $this->signature);
            $this->info($message);

            return;
        }

        $placeCode = $this->argument('placeCode') ?: config('notification.weather_for_basketball.place_code_to_check');
        $startDateTime = $this->argument('from') ?: now()->toDateTimeString();
        $endDateTime = $this->argument('to') ?: now()->addHours(config('weather.rules.hours_to_check'))->toDateTimeString();
        $cacheKey = 'weather_checked_'.$placeCode;

        /** @var Carbon|null $weatherUpdated */
        $weatherUpdated = Cache::get($cacheKey);

        if ($weatherUpdated && $weatherUpdated->isCurrentHour()) {
            return;
        }

        WeatherForBasketballChecked::dispatch($this->getResponse($placeCode, $startDateTime, $endDateTime));
        Cache::put($cacheKey, now(), now()->addHour());
        $this->info('Weather checked.');
    }

    /**
     * @throws Exception
     */
    private function getResponse(string $placeCode, string $startDateTime, string $endDateTime): WeatherResponse
    {
        return $this->manager->manage($placeCode, $startDateTime, $endDateTime);
    }

    private function canHandle(): bool
    {
        $monthAndDay = Carbon::now()->format('m-d');
        $startNotify = config('notification.weather_for_basketball.start_notify');
        $endNotify = config('notification.weather_for_basketball.end_notify');

        return $monthAndDay >= $startNotify && $monthAndDay <= $endNotify;
    }
}
