<?php

declare(strict_types=1);

namespace Src\Radiation\Client\Request;

class AlphaCharlieRequest extends AbstractRequest
{
    public function getHeaders(): array
    {
        return [
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function getBody(): string
    {
        return '';
    }

    public function getUri(): string
    {
        return config('provider.alpha_charlie_api_endpoint');
    }
}
