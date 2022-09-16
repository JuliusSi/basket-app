<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Model\Payment;
use App\Payment\Event\SmsPaymentCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as ResponseBuilder;
use Omnipay\Common\GatewayInterface;
use Omnipay\Omnipay;

class PaymentApiController extends Controller
{
    private GatewayInterface $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(config('payments.paypal.client_id'));
        $this->gateway->setSecret(config('payments.paypal.client_secret'));
//        $this->gateway->setTestMode(true);
    }

    public function pay(PaymentRequest $request)
    {
        $currency = config('payments.paypal.currency');

        $successUrl = route('payment-success');

        $errorUrl = route('payment-error');

        try {
            $options = [
                'amount' => $request->get('amount'),
                'currency' => $currency,
                'returnUrl' => $successUrl,
                'cancelUrl' => $errorUrl,
            ];
            $response = $this->gateway->purchase($options)->send();

            if ($response->isRedirect()) {
                $data = $response->getData();

                $payment = new Payment();
                $payment->user_id = auth()->user()->id;
                $payment->sku = $request->get('sku');
                $payment->quantity = $request->get('quantity');
                $payment->payment_id = $data['id'];
                $payment->amount = $data['transactions'][0]['amount']['total'];
                $payment->currency = $currency;
                $payment->status = $data['state'];
                $payment->save();

                $redirectLink = $data['links'][1]['href'];

                return ResponseBuilder::make(
                    [
                        'link' => $redirectLink,
                    ]
                );
            }
            logs()->error($response->getMessage());

            return ResponseBuilder::make([$response->getMessage()]);
        } catch (\Throwable $exception) {
            logs()->error($exception->getMessage());

            return $exception->getMessage();
        }
    }

    public function success(Request $request)
    {
        $payment = Payment::where([
            'payment_id' => $request->get('paymentId'),
            'status' => Payment::STATUS_APPROVED,
        ])->first();

        if ($payment) {
            $message = 'Toks apmokėjimas jau užfiksuotas.';

            return view('payment.error', compact(['message']));
        }

        $payment = Payment::where([
            'payment_id' => $request->get('paymentId'),
            'status' => Payment::STATUS_CREATED,
        ])->firstOrFail();

        if (!$payment) {
            $message = 'Toks mokėjimas nerastas.';

            return view('payment.error', compact(['message']));
        }

        if ($request->get('paymentId') && $request->get('PayerID')) {
            $transaction = $this->gateway->completePurchase([
                'payer_id' => $request->get('PayerID'),
                'transactionReference' => $request->get('paymentId'),
            ]);

            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $data = $response->getData();
                $payment = Payment::where([
                    'payment_id' => $data['id'],
                    'status' => Payment::STATUS_CREATED,
                ])->firstOrFail();
                $payment->update([
                    'status' => Payment::STATUS_APPROVED,
                    'payer_id' => $data['payer']['payer_info']['payer_id'],
                    'payer_email' => $data['payer']['payer_info']['email'],
                ]);

                SmsPaymentCompleted::dispatch($payment->id);

                $message = 'Apmokėjimas sėkmingas!';

                return view('payment.success', compact(['message']));
            }

            $message = 'Apmokėti nepavyko. '.$response->getMessage();

            return view('payment.error', compact(['message']));
        }

        $message = 'Apmokėti nepavyko.';

        return view('payment.error', compact(['message']));
    }

    public function error(Request $request)
    {
        $message = 'Apmokėti nepavyko.';

        return view('payment.error', compact(['message']));
    }
}
