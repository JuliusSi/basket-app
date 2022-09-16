<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Model\Payment;
use Illuminate\Console\Command;

class PaymentDeleteCommand extends Command
{
    protected $signature = 'payment:delete-not-approved';

    protected $description = 'Deletes not approved payments';

    public function handle(): void
    {
        $this->info('Starting delete...');

        $date = now()->subMonths(3)->toDateTime();
        $this->info(sprintf('Payments created earlier than the date %s will be deleted.', $date->format('Y-m-d H:i')));

        $payments = Payment::where('status', '!=', Payment::STATUS_APPROVED)->where('created_at', '<', $date)->get();
        $count = \count($payments->all());
        $this->info(sprintf('Records count: %s', $count));

        if ($count) {
            logs()->info('Not approved payments will be deleted.', [
                'count' => $count,
            ]);
        }

        foreach ($payments as $payment) {
            $this->info(sprintf('Deleting payment id: %s.', $payment->id));
            $payment->delete();
        }

        $this->info('Records have been deleted.');
    }
}
