<?php

declare(strict_types=1);

namespace Src\Radiation\Client\Request;

class GolfCharlieRequest extends AbstractRequest
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
        return config('provider.golf_charlie_api_endpoint');
    }
}
