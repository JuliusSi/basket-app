<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\Http\Requests\WeatherWarningsRequest;
use App\Model\PlaceCode;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Core\Logger\Event\ActionDone;
use Core\Logger\Model\Log;
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
        $place = PlaceCode::find($request->get('place'));
        $startDateTime = $request->get('start_date');
        $endDateTime = $request->get('end_date');
        $warnings = $this->weatherCheckManager->manage($place->code, $startDateTime, $endDateTime);
        event(new ActionDone($this->getActionLog($place->code)));

        return $this->serialize($warnings, 'array<' . Warning::class . '>');
    }

    private function getActionLog(string $placeCode): Log
    {
        $message = 'Vartotojas {username} tikrino ar oras tinkamas krepšiniui ({place})';
        $context = [
            'username' => auth()->user()->username,
            'place' => __(sprintf('weather.place_codes.%s',  $placeCode)),
        ];

        return Log::create($message, $context);
    }
}
