<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HighestRadiationRequest;
use App\Http\Service\RadiationService;
use App\RadiationChecker\Model\Radiation;
use Symfony\Component\HttpFoundation\Response;

class RadiationApiController extends Controller
{
    public function getRadiationInfo(RadiationService $radiationService): Response
    {
        return $radiationService->getRadiationInfo();
    }

    public function getHighestRadiation(HighestRadiationRequest $request)
    {
        $measuredFrom = $request->get('measured_from');
        $measuredTo = $request->get('measured_to');

        return Radiation::whereIn('meter', $request->get('meter_names'))
            ->when(
                $measuredFrom && $measuredTo,
                function ($query) use ($measuredFrom, $measuredTo) {
                    $query->whereBetween('measured_at', [$measuredFrom, $measuredTo]);
                }
            )->orderBy('usvph', 'DESC')->orderBy('measured_at', 'DESC')->first();
    }
}
