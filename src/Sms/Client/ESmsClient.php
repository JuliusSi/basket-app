<?php

declare(strict_types=1);

namespace Src\Sms\Client;

use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;
use Src\Sms\Exception\SmsSendingException;

class ESmsClient extends AbstractClient
{
    private const RESPONSE_SUCCESS = 'OK';

    public function getResponse(RequestInterface $request): string
    {
        $content = parent::getResponse($request);
        if ($content !== self::RESPONSE_SUCCESS) {
            throw new SmsSendingException(sprintf('Error: %s', $content));
        }

        return $content;
    }
}
