<?php

namespace Src\Facebook\Client\Response;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Response
 * @package Src\Facebook\Client\Response
 */
class Response
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("id")
     */
    private string $id;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("post_id")
     */
    private ?string $postId = null;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param  string  $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getPostId(): ?string
    {
        return $this->postId;
    }

    /**
     * @param  string|null  $postId
     */
    public function setPostId(?string $postId): void
    {
        $this->postId = $postId;
    }
}
