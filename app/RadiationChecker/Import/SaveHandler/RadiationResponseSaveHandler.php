<?php

declare(strict_types=1);

namespace App\RadiationChecker\Import\SaveHandler;

use App\RadiationChecker\Model\Radiation;
use App\RadiationChecker\Resolver\RadiationStatusResolver;
use Src\Radiation\Client\Response\Response;

class RadiationResponseSaveHandler
{
    public function __construct(private readonly RadiationStatusResolver $radiationStatusResolver)
    {
    }

    public function save(Response $result): void
    {
        $radiationModel = new Radiation();
        $radiationModel->meter = $result->getMeterName();
        $radiationModel->usvph = $result->getRadiationBackground();
        $radiationModel->measured_at = $result->getLastUpdate();
        $radiationModel->status = $this->radiationStatusResolver->resolve($result->getRadiationBackground());
        $radiationModel->save();
    }
}
