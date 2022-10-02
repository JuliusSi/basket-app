<?php

declare(strict_types=1);

namespace App\User\Listener;

use App\Model\Payment;
use App\Payment\Event\SmsPaymentCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateSmsBalance implements ShouldQueue
{
    public function __invoke(SmsPaymentCompleted $payment): void
    {
        $this->handleBalance($payment->paymentId);
    }

    private function handleBalance(int $paymentId): void
    {
        /** @var Payment $payment */
        $payment = Payment::with('user')->findOrFail($paymentId);

        $this->updateUserSmsBalance($payment);

        $payment->user->userNotifications()->create([
            'name' => 'Atnaujintas Jūsų SMS balansas!',
            'description' => sprintf('Į Jūsų SMS balansą pridedame + %s SMS.', $payment->quantity),
        ]);
    }

    private function updateUserSmsBalance(Payment $payment): void
    {
        $user = $payment->user;
        $newBalance = $user->sms + $payment->quantity;

        $user->update(['sms' => $newBalance]);
    }
}
