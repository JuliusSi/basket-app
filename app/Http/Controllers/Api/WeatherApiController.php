<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeatherWarningsRequest;
use App\Http\Service\WeatherWarningsService;
use App\Model\PlaceCode;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Response as ResponseBuilder;

/**
 * Class WeatherApiController
 * @package App\Http\Controllers\Api
 */
class WeatherApiController extends Controller
{
    /**
     * @param  WeatherWarningsRequest  $request
     * @param  WeatherWarningsService  $weatherWarningsService
     * @return Response
     */
    public function getWeatherWarnings(WeatherWarningsRequest $request, WeatherWarningsService $weatherWarningsService): Response
    {
        return $weatherWarningsService->getResponse($request);
    }

    /**
     * @return JsonResponse
     */
    public function getAvailablePlaces(): Response
    {
        $places = PlaceCode::all();

        return ResponseBuilder::json($places);
    }
}
