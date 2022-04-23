<?php

declare(strict_types=1);

namespace Src\Sms\Client;

use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;
use Illuminate\Support\Facades\Log;
use Src\Sms\Client\Request\ESmsRequest;
use Src\Sms\Exception\SmsSendingException;

class ESmsClient extends AbstractClient
{
    private const RESPONSE_SUCCESS = 'OK';

    public function getResponse(RequestInterface $request): string
    {
        return $this->handle($request);
    }

    /**
     * @throws SmsSendingException
     */
    private function handle(RequestInterface $request): string
    {
        $this->logRequestData($request);

        return $this->handleResponseData($request);
    }

    /**
     * @throws SmsSendingException
     */
    private function handleResponseData(RequestInterface $request): string
    {
        $content = parent::getResponse($request);

        if (self::RESPONSE_SUCCESS !== $content) {
            throw new SmsSendingException(sprintf('Error: %s', $content));
        }

        return $content;
    }

    private function logRequestData(RequestInterface $request): void
    {
        if (!$request instanceof ESmsRequest) {
            return;
        }

        $sms = $request->sms();

        Log::channel('client')->info('Sms request data', [
            'sms_content' => $sms->content(),
            'sms_length' => \strlen($sms->content()),
            'sms_sender' => $sms->sender(),
        ]);
    }
}
