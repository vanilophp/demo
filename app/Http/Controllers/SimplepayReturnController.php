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

class SimplepayReturnController extends Controller
{
    public function return(Request $request)
    {
        Log::debug('SimplePay confirmation', $request->toArray());

        $response = PaymentGateways::make('simplepay')->processPaymentResponse($request);
        $payment  = Payment::findByPaymentId($response->getPaymentId());

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

        return view('payment.return_simplepay', [
            'response' => $response,
            'payment'  => $payment,
            'order'    => $payment->getPayable()
        ]);
    }
}
