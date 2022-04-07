<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeatherInformationRequest;
use App\Http\Requests\WeatherWarningsRequest;
use App\Http\Service\WeatherInformationService;
use App\Http\Service\WeatherWarningsService;
use App\Model\PlaceCode;
use Exception;
use Illuminate\Http\Response;

/**
 * Class WeatherApiController.
 */
class WeatherApiController extends Controller
{
    /**
     * @throws Exception
     */
    public function getWeatherWarnings(
        WeatherWarningsRequest $request,
        WeatherWarningsService $weatherWarningsService
    ): Response {
        return $weatherWarningsService->getResponse($request);
    }

    /**
     * @return string
     */
    public function getAvailablePlaces(): string
    {
        return PlaceCode::all()->toJson();
    }

    /**
     * @throws Exception
     */
    public function getWeatherInformation(WeatherInformationRequest $request, WeatherInformationService $weatherService): Response
    {
        return $weatherService->getResponse($request);
    }
}
