<?php

namespace App\Verifier\Handler;

use App\Model\User;
use App\Model\UserAttribute;
use App\Verifier\Sender\PhoneVerificationRequestSender;
use Src\Sms\Client\Response\SendVerifyResponse;

/**
 * Class PhoneVerificationRequestHandler
 * @package App\Verifier\Handler
 */
class PhoneVerificationRequestHandler
{
    /**
     * @var PhoneVerificationRequestSender
     */
    private PhoneVerificationRequestSender $sender;

    /**
     * PhoneVerificationRequestHandler constructor.
     * @param  PhoneVerificationRequestSender  $sender
     */
    public function __construct(PhoneVerificationRequestSender $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param  User  $user
     */
    public function handle(User $user): void
    {
        $response = $this->sender->sendVerification($user);
        if ($response && $response->isStatusOpen()) {
            $this->saveVerificationData($response, $user);
        }
    }

    /**
     * @param  SendVerifyResponse  $response
     * @param  User  $user
     */
    private function saveVerificationData(SendVerifyResponse $response, User $user): void
    {
        $this->buildAndSaveAttribute(
            $user,
            UserAttribute::ATTRIBUTE_NAME_PHONE_VERIFICATION_ID,
            $response->getOtpId()
        );
    }

    /**
     * @param  User  $user
     * @param  string  $name
     * @param  string  $value
     */
    private function buildAndSaveAttribute(User $user, string $name, string $value): void
    {
        $attribute = new UserAttribute();
        $attribute->setAttribute('user_id', $user->getAttribute('id'));
        $attribute->setAttribute('name', $name);
        $attribute->setAttribute('value', $value);

        $attribute->save();
    }
}
