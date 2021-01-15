<?php

namespace App\Http\Service;

use App\RadiationChecker\Service\RadiationInfoService;
use Exception;
use App\RadiationChecker\Model\RadiationInfo;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RadiationService
 * @package App\Http\Service
 */
class RadiationService extends AbstractService
{
    /**
     * @var RadiationInfoService
     */
    private RadiationInfoService $radiationInfoService;

    /**
     * RadiationService constructor.
     * @param  RadiationInfoService  $radiationInfoService
     */
    public function __construct(RadiationInfoService $radiationInfoService)
    {
        $this->radiationInfoService = $radiationInfoService;
    }

    /**
     * @return Response
     */
    public function getRadiationInfo(): Response
    {
        try {
            $response = $this->serialize($this->radiationInfoService->getRadiationInfo(), RadiationInfo::class);
            return $this->createResponse($response);
        } catch (Exception $exception) {
            return $this->createJsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
