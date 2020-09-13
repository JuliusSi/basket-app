<?php

namespace Src\Sms\Client\Response;

use Src\Sms\Model\Data;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Response
 * @package Src\Sms\Client\Response
 */
class Response
{
    /**
     * @JMS\Type("Src\Sms\Model\Data>")
     * @JMS\SerializedName("data")
     *
     * @var Data $data
     */
    private Data $data;

    /**
     * @return Data
     */
    public function getData(): Data
    {
        return $this->data;
    }

    /**
     * @param  Data  $data
     */
    public function setData(Data $data): void
    {
        $this->data = $data;
    }
}
