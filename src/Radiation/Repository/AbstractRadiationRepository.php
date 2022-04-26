<?php

declare(strict_types=1);

namespace Src\Radiation\Repository;

use Exception;
use Src\Radiation\Client\DefaultClient;
use Src\Radiation\Client\Request\AbstractRequest;
use Src\Radiation\Client\Response\Response;

abstract class AbstractRadiationRepository
{
    public function __construct(private readonly DefaultClient $client)
    {
    }

    /**
     * @throws Exception
     */
    protected function getRawResponse(AbstractRequest $request): Response
    {
        return $this->client->getDeserializedResponse($request, Response::class);
    }
}
