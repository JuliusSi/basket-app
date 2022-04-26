<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\Http\Requests\WeatherWarningsRequest;
use App\Model\PlaceCode;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Exception;
use Illuminate\Http\Response;

class WeatherWarningsService extends AbstractService
{
    public function __construct(private readonly WeatherCheckManager $weatherCheckManager)
    {
    }

    /**
     * @throws Exception
     */
    public function getResponse(WeatherWarningsRequest $request): Response
    {
        $result = $this->getWarnings($request);

        return $this->createResponse($result)->header('Content-Type', 'application/json');
    }

    /**
     * @throws Exception
     */
    private function getWarnings(WeatherWarningsRequest $request): string
    {
        $place = PlaceCode::find($request->get('place'));
        $startDateTime = $request->get('start_date');
        $endDateTime = $request->get('end_date');
        $warnings = $this->weatherCheckManager->manage($place->code, $startDateTime, $endDateTime);

        return $this->serialize($warnings, 'array<'.Warning::class.'>');
    }
}
