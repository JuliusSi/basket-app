<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\Http\Requests\WeatherInformationRequest;
use App\Model\PlaceCode;
use App\WeatherChecker\Service\WeatherService;
use Exception;
use Illuminate\Http\Response;
use Src\Weather\Client\Response\ForecastTimestamp;

class WeatherInformationService extends AbstractService
{
    public function __construct(private WeatherService $weatherService)
    {
    }

    /**
     * @throws Exception
     */
    public function getResponse(WeatherInformationRequest $request): Response
    {
        $result = $this->getWeatherInformation($request);

        return $this->createResponse($result)->header('Content-Type', 'application/json');
    }

    /**
     * @throws Exception
     */
    private function getWeatherInformation(WeatherInformationRequest $request): string
    {
        $data = [
            PlaceCode::findOrFail($request->get('place'))->getAttribute('code'),
            $request->get('start_date'),
            $request->get('end_date'),
        ];
        $result = $this->weatherService->getFilteredForecasts(...$data);

        return $this->serialize($result, 'array<'.ForecastTimestamp::class.'>');
    }
}
