<?php

namespace Src\Weather\Client\Response;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Place
 * @package Src\Weather\Client\Response
 */
class Place
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("code")
     */
    private $code;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param  mixed  $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }
}
