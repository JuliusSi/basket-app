<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\RadiationService;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RadiationApiController
 * @package App\Http\Controllers\Api
 */
class RadiationApiController extends Controller
{
    /**
     * @param  RadiationService  $radiationService
     * @return Response
     */
    public function getRadiationInfo(RadiationService $radiationService): Response
    {
        return $radiationService->getRadiationInfo();
    }
}
