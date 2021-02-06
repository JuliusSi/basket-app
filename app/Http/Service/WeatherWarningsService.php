<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\Http\Requests\WeatherWarningsRequest;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WeatherWarningsService
 * @package App\Http\Service
 */
class WeatherWarningsService extends AbstractService
{
    /**
     * @var WeatherCheckManager
     */
    private WeatherCheckManager $weatherCheckManager;

    /**
     * WeatherWarningsService constructor.
     * @param  WeatherCheckManager  $weatherCheckManager
     */
    public function __construct(WeatherCheckManager $weatherCheckManager)
    {
        $this->weatherCheckManager = $weatherCheckManager;
    }

    /**
     * @param  WeatherWarningsRequest  $request
     * @return Response
     */
    public function getResponse(WeatherWarningsRequest $request): Response
    {
        $result = $this->getWarnings($request);

        return $this->createResponse($result)->header('Content-Type', 'application/json');
    }

    /**
     * @param  WeatherWarningsRequest  $request
     * @return string
     */
    private function getWarnings(WeatherWarningsRequest $request): string
    {
        $place = $request->get('place');
        $startDateTime = Carbon::createFromFormat('Y-m-d', $request->get('start_date'))->toDateTimeString();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $request->get('end_date'))->toDateTimeString();
        $warnings = $this->weatherCheckManager->manage($place, $startDateTime, $endDateTime);

        return $this->serialize($warnings, 'array<' . Warning::class . '>');
    }
}
