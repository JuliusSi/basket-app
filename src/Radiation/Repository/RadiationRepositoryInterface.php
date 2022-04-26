<?php

declare(strict_types=1);

namespace Src\Radiation\Repository;

use Src\Radiation\Client\Response\Response;

interface RadiationRepositoryInterface
{
    public function find(): Response;
}
