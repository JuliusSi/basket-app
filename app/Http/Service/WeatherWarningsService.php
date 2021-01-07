<?php

namespace App\Http\Service;

use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Core\Helpers\Traits\SerializationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as ResponseBuilder;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WeatherWarningsService
 * @package App\Http\Service
 */
class WeatherWarningsService
{
    use SerializationTrait;

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
        if ($errors) {
            return ResponseBuilder::json($errors, Response::HTTP_BAD_REQUEST)
                ->header('Content-Type', 'application/json');
        }

        return ResponseBuilder::make($this->getWarnings($request), 200)
            ->header('Content-Type', 'application/json');
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
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

        return $validator->fails() ? $validator->errors()->all() : [];
    }
}
