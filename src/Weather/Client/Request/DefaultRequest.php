<?php

namespace Src\Weather\Client\Request;

use Psr\Http\Message\UriInterface;

/**
 * Class FacebookPhotoPostRequest
 * @package Src\Weather\Client\Request
 */
class DefaultRequest extends AbstractRequest
{
    public const FORECASTS_PARAM = '/forecasts';
    public const LONG_TERM_PARAM = '/long-term';

    /**
     * @var string
     */
    private string $city;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'GET';
    }

    /**
     * @return UriInterface|string
     */
    public function getUri()
    {
        return config('provider.meteo_weather_api_endpoint')
            . $this->city . self::FORECASTS_PARAM . self::LONG_TERM_PARAM;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param  string  $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }
}
