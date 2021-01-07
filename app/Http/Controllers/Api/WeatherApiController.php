<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\WeatherWarningsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Response as ResponseBuilder;

/**
 * Class WeatherApiController
 * @package App\Http\Controllers\Api
 */
class WeatherApiController extends Controller
{
    /**
     * @var WeatherWarningsService
     */
    private WeatherWarningsService $weatherWarningsService;

    /**
     * WeatherApiController constructor.
     * @param  WeatherWarningsService  $weatherWarningsService
     */
    public function __construct(WeatherWarningsService $weatherWarningsService)
    {
        $this->weatherWarningsService = $weatherWarningsService;
    }

    /**
     * @param  Request  $request
     * @return Response
     */
    public function getWeatherWarnings(Request $request): Response
    {
        return $this->weatherWarningsService->getResponse($request);
    }

    /**
     * @return JsonResponse
     */
    public function getAvailablePlaces(): Response
    {
        $places = config('weather.available_places');

        return ResponseBuilder::json($places);
    }
}
