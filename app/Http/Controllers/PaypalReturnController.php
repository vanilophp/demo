<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vanilo\Payment\Events\PaymentCompleted;
use Vanilo\Payment\Events\PaymentDeclined;
use Vanilo\Payment\Events\PaymentPartiallyReceived;
use Vanilo\Payment\Models\Payment;
use Vanilo\Payment\Models\PaymentStatus;
use Vanilo\Payment\PaymentGateways;

class PaypalReturnController extends Controller
{
    public function return(Request $request, string $paymentId)
    {
        Log::debug('PayPal confirmation', $request->toArray());

        $response = PaymentGateways::make('paypal')->processPaymentResponse($request);
        $payment  = Payment::findByPaymentId($paymentId);

        if (!$payment) {
            return new ModelNotFoundException('Could not locate payment with id ' . $response->getPaymentId());
        }

        if ($response->wasSuccessful()) {
            $payment->amount_paid = $response->getAmountPaid();

            if ($response->getAmountPaid() < $payment->getAmount()) {
                $payment->status         = PaymentStatus::PARTIALLY_PAID();
                $payment->status_message = $response->getMessage();
                $payment->save();
                event(new PaymentPartiallyReceived($payment, $response->getAmountPaid()));
            } else {
                $payment->status         = PaymentStatus::PAID();
                $payment->status_message = $response->getMessage();
                $payment->save();
                event(new PaymentCompleted($payment));
            }
        } else {
            $payment->status         = PaymentStatus::DECLINED();
            $payment->status_message = $response->getMessage();
            $payment->save();
            event(new PaymentDeclined($payment));
        }

        return view('payment.return_paypal', [
            'response' => $response,
            'payment'  => $payment,
            'order'    => $payment->getPayable()
        ]);
    }

    public function cancel(Request $request, string $paymentId)
    {
        $payment = Payment::findByPaymentId($paymentId);

        return view('payment.cancel', [ // The view is from your application
            'payment' => $payment,
            'order'   => $payment->getPayable(),
        ]);
    }
}
