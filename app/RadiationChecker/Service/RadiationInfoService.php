<?php

namespace App\RadiationChecker\Service;

use App\RadiationChecker\Model\RadiationInfo;
use App\RadiationChecker\Resolver\RadiationStatusResolver;
use Exception;
use Src\Radiation\Client\Response\Response;
use Src\Radiation\Repository\CachedRadiationRepository;
use Src\Radiation\Repository\RadiationRepository;

/**
 * Class RadiationInfoService
 * @package App\RadiationChecker\Service
 */
class RadiationInfoService
{
    /**
     * @var CachedRadiationRepository
     */
    private CachedRadiationRepository $cachedRadiationRepository;

    /**
     * @var RadiationStatusResolver
     */
    private RadiationStatusResolver $radiationStatusResolver;

    /**
     * RadiationInfoService constructor.
     * @param  CachedRadiationRepository  $cachedRadiationRepository
     * @param  RadiationStatusResolver  $radiationStatusResolver
     */
    public function __construct(CachedRadiationRepository $cachedRadiationRepository, RadiationStatusResolver $radiationStatusResolver)
    {
        $this->cachedRadiationRepository = $cachedRadiationRepository;
        $this->radiationStatusResolver = $radiationStatusResolver;
    }

    public function getRadiationInfo(): ?RadiationInfo
    {
        $rawResponse = $this->getRawResponse();
        if (!$rawResponse || !$rawResponse->getData()->getRadiationBackground()) {
            return null;
        }

        return $this->buildResponse($rawResponse);
    }

    /**
     * @param  Response  $rawResponse
     * @return RadiationInfo
     */
    private function buildResponse(Response $rawResponse): RadiationInfo
    {
        $response = new RadiationInfo();
        $response->setUpdatedAt($rawResponse->getLastUpdate());
        $response->setRadiationBackground($rawResponse->getData()->getRadiationBackground());
        $status = $this->radiationStatusResolver->resolve($rawResponse->getData()->getRadiationBackground());
        $response->setStatus($status);

        return $response;
    }

    /**
     * @return Response|null
     */
    public function getRawResponse(): ?Response
    {
        try {
            return $this->cachedRadiationRepository->find();
        } catch (Exception $exception) {
            return null;
        }
    }
}
