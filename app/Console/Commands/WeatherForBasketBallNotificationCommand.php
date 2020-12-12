<?php

namespace App\Console\Commands;

use App\Notifier\Manager\WeatherForBasketBallNotificationManager;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Class WeatherForBasketBallNotificationCommand
 * @package App\Console\Commands
 */
class WeatherForBasketBallNotificationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'weatherForBasketBall:notify';

    /**
     * @var string
     */
    protected $description = 'Notifies about weather for basketball.';

    /**
     * @var WeatherForBasketBallNotificationManager
     */
    private WeatherForBasketBallNotificationManager $manager;

    /**
     * WeatherForBasketBallNotificationCommand constructor.
     * @param  WeatherForBasketBallNotificationManager  $manager
     */
    public function __construct(WeatherForBasketBallNotificationManager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        if (!$this->canHandle()) {
            $message = sprintf('Command %s is not executed due to configuration.', $this->signature);
            Log::channel('command')->notice($message);
            return;
        }

        $this->manager->manage();
    }

    /**
     * @return bool
     */
    private function canHandle(): bool
    {
        $monthAndDay = Carbon::now()->format('m-d');
        $startNotify = config('notification.weather_for_basketball.start_notify');
        $endNotify = config('notification.weather_for_basketball.end_notify');

        return $monthAndDay >= $startNotify && $monthAndDay <= $endNotify;
    }
}
