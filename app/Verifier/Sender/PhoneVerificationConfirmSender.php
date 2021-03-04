<?php

namespace App\Verifier\Sender;

use Exception;
use Src\Sms\Client\Response\VerifyResponse;
use Src\Sms\Model\Verification;
use Src\Sms\Repository\SmsVerifyRepository;

/**
 * Class PhoneVerificationConfirmSender
 * @package App\Verifier\Sender
 */
class PhoneVerificationConfirmSender
{
    /**
     * @var SmsVerifyRepository
     */
    private SmsVerifyRepository $repository;

    /**
     * PhoneVerificationConfirmSender constructor.
     * @param  SmsVerifyRepository  $repository
     */
    public function __construct(SmsVerifyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param  string  $otpId
     * @param  string  $code
     * @return VerifyResponse|null
     */
    public function sendConfirmation(string $otpId, string $code): ?VerifyResponse
    {
        try {
            return $this->repository->verify($this->buildVerification($otpId, $code));
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * @param  string  $otpId
     * @param  string  $code
     * @return Verification
     */
    private function buildVerification(string $otpId, string $code): Verification
    {
        $verification = new Verification();
        $verification->setOtpId($otpId);
        $verification->setOtpCode($code);

        return $verification;
    }
}
