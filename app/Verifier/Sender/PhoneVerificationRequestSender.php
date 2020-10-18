<?php

namespace App\Verifier\Sender;

use App\Model\User;
use Exception;
use Src\Sms\Client\Response\SendVerifyResponse;
use Src\Sms\Model\VerificationMessage;
use Src\Sms\Repository\SmsVerifyRepository;

/**
 * Class PhoneVerificationRequestSender
 * @package App\Verifier\Sender
 */
class PhoneVerificationRequestSender
{
    /**
     * @var SmsVerifyRepository
     */
    private SmsVerifyRepository $repository;

    /**
     * PhoneVerificationSender constructor.
     * @param  SmsVerifyRepository  $repository
     */
    public function __construct(SmsVerifyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param  User  $user
     * @return SendVerifyResponse|null
     */
    public function sendVerification(User $user): ?SendVerifyResponse
    {
       return $this->send($user);
    }

    /**
     * @param  User  $user
     * @return VerificationMessage
     */
    private function buildVerificationMessage(User $user): VerificationMessage
    {
        $verification = new VerificationMessage();
        $verification->setPhoneNumber($user->getAttribute('phone'));
        $verification->setMessage(__('verification.phone.new_user_verification_code'));
        $verification->setSenderName(config('sms.sender_name'));

        return $verification;
    }

    /**
     * @param  User  $user
     * @return SendVerifyResponse|null
     */
    private function send(User $user): ?SendVerifyResponse
    {
        try {
            return $this->repository->sendVerification($this->buildVerificationMessage($user));
        } catch (Exception $exception) {
            return null;
        }
    }
}
