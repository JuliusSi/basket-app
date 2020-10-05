<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Traits\SerializationTrait;
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

        return $this->serialize($warnings, 'array<' . Warning::class . '>');
    }
}
