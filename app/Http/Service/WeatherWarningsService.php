<?php

namespace App\Http\Service;

use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
     * @param  Request  $request
     * @return Response
     */
    public function getResponse(Request $request): Response
    {
        $errors = $this->validate($request);
        if (!$errors) {
            $result = $this->getWarnings($request);

            return $this->createResponse($result)->header('Content-Type', 'application/json');
        }

        return $this->createJsonResponse($errors, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param  Request  $request
     * @return string
     */
    private function getWarnings(Request $request): string
    {
        $place = $request->get('place');
        $startDateTime = Carbon::createFromFormat('Y-m-d', $request->get('start_date'))->toDateTimeString();
        $endDateTime = Carbon::createFromFormat('Y-m-d', $request->get('end_date'))->toDateTimeString();
        $warnings = $this->weatherCheckManager->manage($place, $startDateTime, $endDateTime);

        return $this->serialize($warnings, 'array<' . Warning::class . '>');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function validate(Request $request): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'place' => 'required',
                'start_date' => 'required|date|before:end_date|date_format:Y-m-d',
                'end_date' => 'required|date|after:start_date|date_format:Y-m-d',
            ]
        );

        return $validator->errors()->all();
    }
}
