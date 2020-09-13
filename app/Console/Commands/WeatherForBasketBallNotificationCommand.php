<?php

namespace App\Console\Commands;

use App\Notifier\Manager\WeatherForBasketBallNotificationManager;
use Illuminate\Console\Command;

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
        $this->manager->manage();
    }
}
