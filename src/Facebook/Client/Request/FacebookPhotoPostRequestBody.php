<?php

namespace Src\Facebook\Client\Request;

use JMS\Serializer\Annotation as JMS;

/**
 * Class FacebookPhotoPostRequestBody
 * @package Src\Facebook\Client\Request
 */
class FacebookPhotoPostRequestBody
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("url")
     */
    private string $imageUrl;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("caption")
     */
    private string $imageCaption;

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param  string  $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string
     */
    public function getImageCaption(): string
    {
        return $this->imageCaption;
    }

    /**
     * @param  string  $imageCaption
     */
    public function setImageCaption(string $imageCaption): void
    {
        $this->imageCaption = $imageCaption;
    }
}
