<?php

namespace App\Http\Controllers\Api;

use Core\Helpers\Traits\SerializationTrait;
use App\Http\Controllers\Controller;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

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
     * @param  Request  $request
     * @return string
     */
    public function getWeatherWarnings(Request $request): string
    {
        $warnings = $this->weatherCheckManager->manage($request->get('place'));

        return $this->serialize($warnings, 'array<' . Warning::class . '>');
    }

    /**
     * @return JsonResponse
     */
    public function getAvailablePlaces(): JsonResponse
    {
        $places = config('weather.available_places');

        return Response::json($places);
    }
}
