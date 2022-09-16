<?php

declare(strict_types=1);

namespace App\User\Listener;

use App\Model\Payment;
use App\Payment\Event\SmsPaymentCompleted;

class CreateSmsPaymentNotification
{
    public function __invoke(SmsPaymentCompleted $payment): void
    {
        $this->createNotification($payment->paymentId);
    }

    private function createNotification(int $paymentId): void
    {
        $payment = Payment::with('user')->findOrFail($paymentId);

        $payment->user->userNotifications()->create([
            'name' => 'Jūsų mokėjimas užregistruotas!',
            'description' => sprintf('Prekė %s, kiekis %s, suma %s %s.', $payment->sku, $payment->quantity, $payment->amount, $payment->currency),
        ]);
    }
}
