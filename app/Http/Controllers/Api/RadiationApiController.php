<?php

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
     * @var RadiationService
     */
    private RadiationService $radiationService;

    /**
     * RadiationApiController constructor.
     * @param  RadiationService  $radiationService
     */
    public function __construct(RadiationService $radiationService)
    {
        $this->radiationService = $radiationService;
    }

    /**
     * @return Response
     */
    public function getRadiationInfo(): Response
    {
        return $this->radiationService->getRadiationInfo();
    }
}
