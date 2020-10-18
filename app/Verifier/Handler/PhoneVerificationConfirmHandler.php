<?php

namespace App\Verifier\Handler;

use App\Model\User;
use App\Model\UserAttribute;
use App\Verifier\Sender\PhoneVerificationConfirmSender;

/**
 * Class PhoneVerificationConfirmHandler
 * @package App\Verifier\Handler
 */
class PhoneVerificationConfirmHandler
{
    /**
     * @var PhoneVerificationConfirmSender
     */
    private PhoneVerificationConfirmSender $confirmSender;

    /**
     * PhoneVerificationConfirmHandler constructor.
     * @param  PhoneVerificationConfirmSender  $confirmSender
     */
    public function __construct(PhoneVerificationConfirmSender $confirmSender)
    {
        $this->confirmSender = $confirmSender;
    }

    /**
     * @param  string  $code
     * @param  int  $userId
     */
    public function handle(string $code, int $userId): void
    {
        $isConfirmed = $this->handleConfirmation($code, $userId);
        if (!$isConfirmed) {
            return;
        }

        $this->updateUser($userId);
    }

    /**
     * @param  string  $code
     * @param  int  $userId
     * @return bool
     */
    private function handleConfirmation(string $code, int $userId): bool
    {
        $attribute = $this->getAttribute($userId);
        if (!$attribute) {
            return false;
        }

        return $this->handleResponse($attribute, $code);
    }

    /**
     * @param  UserAttribute  $attribute
     * @param  string  $code
     * @return bool
     */
    private function handleResponse(UserAttribute $attribute, string $code): ?bool
    {
        $response = $this->confirmSender->sendConfirmation($attribute->getAttribute('value'), $code);

        return $response && $response->isSuccess();
    }

    /**
     * @param  int  $userId
     * @return UserAttribute|null
     */
    private function getAttribute(int $userId): ?UserAttribute
    {
        return UserAttribute::where(
            [
                'user_id' => $userId,
                'name' => UserAttribute::ATTRIBUTE_NAME_PHONE_VERIFICATION_ID,
            ]
        )->first();
    }

    /**
     * @param  int  $userId
     */
    private function updateUser(int $userId): void
    {
        User::where('id', $userId)->update(['phone_verified_at' => now()]);
    }
}
