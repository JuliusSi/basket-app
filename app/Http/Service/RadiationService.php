<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\RadiationChecker\Service\RadiationInfoService;
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
        $result = $this->serialize($this->radiationInfoService->getRadiationInfo(), RadiationInfo::class);

        return $this->createResponse($result)->header('Content-Type', 'application/json');
    }
}
