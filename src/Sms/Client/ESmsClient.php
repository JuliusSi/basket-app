<?php

declare(strict_types=1);

namespace Src\Sms\Client;

use Core\Helpers\Interfaces\Request\StatsAwareRequestInterface as RequestInterface;
use Illuminate\Support\Facades\Log;
use Src\Sms\Client\Request\ESmsRequest;
use Src\Sms\Exception\SmsSendingException;

use function strlen;

class ESmsClient extends AbstractClient
{
    private const RESPONSE_SUCCESS = 'OK';

    public function getResponse(RequestInterface $request): string
    {
        $content = parent::getResponse($request);

        $this->handle($request, $content);

        return $content;
    }

    /**
     * @throws SmsSendingException
     */
    private function handle(RequestInterface $request, string $content): void
    {
        $this->logRequestData($request);
        $this->handleResponseData($content);
    }

    /**
     * @throws SmsSendingException
     */
    private function handleResponseData(string $content): void
    {
        if (self::RESPONSE_SUCCESS !== $content) {
            throw new SmsSendingException(sprintf('Error: %s', $content));
        }
    }

    private function logRequestData(RequestInterface $request): void
    {
        if (!$request instanceof ESmsRequest) {
            return;
        }

        $sms = $request->sms();

        Log::channel('client')->info('Sms request data', [
            'sms_content' => $sms->content(),
            'sms_length' => strlen($sms->content()),
            'sms_sender' => $sms->sender(),
        ]);
    }
}
