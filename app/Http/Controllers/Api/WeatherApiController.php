<?php

namespace App\Http\Controllers\Api;

use Core\Helpers\Traits\SerializationTrait;
use App\Http\Controllers\Controller;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;

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
     * WeatherApiController constructor.
     * @param  WeatherCheckManager  $weatherCheckManager
     */
    public function __construct(WeatherCheckManager $weatherCheckManager)
    {
        $this->weatherCheckManager = $weatherCheckManager;
    }

    /**
     * @return string
     */
    public function getWeatherWarnings(): string
    {
        $warnings = $this->weatherCheckManager->manage();

        return $this->serialize($warnings, 'array<' . Warning::class . '>');
    }
}
