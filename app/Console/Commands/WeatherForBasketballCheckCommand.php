<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\WeatherChecker\Event\WeatherForBasketballChecked;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Response\WarningResponse;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class WeatherForBasketballCheckCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'weather:check-weather-for-basketball';

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

        WeatherForBasketballChecked::dispatch($this->getResponse());
        $this->info('Weather checked.');
    }

    /**
     * @throws Exception
     */
    private function getResponse(): WarningResponse
    {
        $placeCode = config('notification.weather_for_basketball.place_code_to_check');
        $endDateTime = $this->getCheckEndDateTime()->toDateTimeString();
        $startDateTime = now()->toDateTimeString();

        return $this->manager->manage($placeCode, $startDateTime, $endDateTime);
    }

    private function getCheckEndDateTime(): Carbon
    {
        return now()->addHours(config('weather.rules.hours_to_check'));
    }

    private function canHandle(): bool
    {
        $monthAndDay = Carbon::now()->format('m-d');
        $startNotify = config('notification.weather_for_basketball.start_notify');
        $endNotify = config('notification.weather_for_basketball.end_notify');

        return $monthAndDay >= $startNotify && $monthAndDay <= $endNotify;
    }
}