<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\RadiationChecker\Model\RadiationInfo;
use App\RadiationChecker\Service\RadiationInfoService;
use Symfony\Component\HttpFoundation\Response;

class RadiationService extends AbstractService
{
    public function __construct(private readonly RadiationInfoService $radiationInfoService)
    {
    }

    public function getRadiationInfo(): Response
    {
        $result = $this->serialize($this->radiationInfoService->getRadiationInfo(), 'array<'.RadiationInfo::class.'>');

        return $this->createResponse($result)->header('Content-Type', 'application/json');
    }
}
