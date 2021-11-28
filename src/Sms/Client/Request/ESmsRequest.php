<?php

declare(strict_types=1);

namespace Src\Sms\Client\Request;

use Src\Sms\Model\ESms;

class ESmsRequest extends AbstractRequest
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(private ESms $smsModel)
    {
    }

    private const PARAM_EMAIL = 'email';
    private const PARAM_PASSWORD = 'password';
    private const PARAM_SENDER = 'from';
    private const PARAM_RECIPIENT = 'to';
    private const PARAM_SMS = 'sms';
    private const PARAM_DATE = 'start date';
    private const PARAM_CALLBACK = 'callback';
    private const PARAM_GROUP = 'group';

    public function getHeaders(): array
    {
        return [];
    }

    public function getBody(): string
    {
        return '';
    }

    public function getUri(): string
    {
        return config('provider.e_sms_api_endpoint');
    }

    public function getQuery(): array
    {
        return [
            self::PARAM_EMAIL => config('provider.e_sms_email'),
            self::PARAM_PASSWORD => config('provider.e_sms_password'),
            self::PARAM_SENDER => $this->smsModel->getSender(),
            self::PARAM_RECIPIENT => $this->smsModel->getRecipient(),
            self::PARAM_SMS => $this->smsModel->getContent(),
            self::PARAM_DATE => $this->smsModel->getDateWhenToSend()?->format(self::DATE_FORMAT),
            self::PARAM_GROUP => $this->smsModel->getGroup(),
            self::PARAM_CALLBACK => $this->smsModel->getCallbackLink(),
        ];
    }

    public function getMethod(): string
    {
        return 'GET';
    }
}
