<?php

namespace Src\Sms\Repository;

use Exception;
use Src\Sms\Client\DefaultClient;
use Src\Sms\Client\Request\SendVerifyRequest;
use Src\Sms\Client\Request\VerifyRequest;
use Src\Sms\Client\Response\SendVerifyResponse;
use Src\Sms\Client\Response\VerifyResponse;
use Src\Sms\Model\Verification;
use Src\Sms\Model\VerificationMessage;

/**
 * Class SmsVerifyRepository
 * @package Src\Sms\Repository
 */
class SmsVerifyRepository
{
    /**
     * @var DefaultClient
     */
    private DefaultClient $client;

    /**
     * SmsVerifyRepository constructor.
     * @param  DefaultClient  $client
     */
    public function __construct(DefaultClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param  VerificationMessage  $message
     * @return SendVerifyResponse
     * @throws Exception
     */
    public function sendVerification(VerificationMessage $message): SendVerifyResponse
    {
        $request = new SendVerifyRequest();
        $request->setMessage($message);

        return $this->client->getDeserializedResponse($request, SendVerifyResponse::class);
    }

    /**
     * @param  Verification  $verification
     * @return VerifyResponse
     * @throws Exception
     */
    public function verify(Verification $verification): VerifyResponse
    {
        $request = new VerifyRequest();
        $request->setVerification($verification);

        return $this->client->getDeserializedResponse($request, VerifyResponse::class);
    }
}
