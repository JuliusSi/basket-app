<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\WeatherChecker\Manager\WeatherCheckManager;
use Src\Sms\Client\Traits\SerializationTrait;

/**
 * Class WeatherApiController
 * @package App\Http\Controllers\Api
 */
class WeatherApiController extends Controller
{
    use SerializationTrait;

    /**
     * @var WeatherCheckManager
     */
    private WeatherCheckManager $weatherCheckManager;

    /**
     * HomeController constructor.
     * @param  WeatherCheckManager  $weatherCheckManager
     */
    public function __construct(WeatherCheckManager $weatherCheckManager)
    {
        $this->weatherCheckManager = $weatherCheckManager;
    }

    /**
     * @return string
     */
    public function weatherWarnings(): string
    {
        $warnings = $this->weatherCheckManager->manage();

        return $this->serialize($warnings);
    }
}
