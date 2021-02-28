<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vanilo\Netopia\Http\Responses\ErrorResponseToNetopia;
use Vanilo\Netopia\Http\Responses\SuccessResponseToNetopia;
use Vanilo\Payment\Events\PaymentCompleted;
use Vanilo\Payment\Events\PaymentDeclined;
use Vanilo\Payment\Events\PaymentPartiallyReceived;
use Vanilo\Payment\Models\Payment;
use Vanilo\Payment\Models\PaymentStatus;
use Vanilo\Payment\PaymentGateways;

class NetopiaReturnController extends Controller
{
    public function return(Request $request)
    {
        $payment = Payment::findByPaymentId($request->get('orderId'));

        return view('payment.return_netopia', [
            'payment' => $payment,
            'order'   => $payment->getPayable(),
            'request' => $request,
        ]);
    }

    public function confirm(Request $request)
    {
        Log::debug('Netopia confirmation', $request->toArray());

        $response = PaymentGateways::make('netopia')->processPaymentResponse($request);
        $payment  = Payment::findByPaymentId($response->getPaymentId());

        if (!$payment) {
            return new ErrorResponseToNetopia(404, 'Could not locate payment with id ' . $response->getPaymentId());
        }

        if ($response->wasSuccessful()) {
            $payment->amount_paid = $response->getAmountPaid();
            if ($response->getAmountPaid() < $payment->getAmount()) {
                $payment->status = PaymentStatus::PARTIALLY_PAID();
                $payment->status_message = $response->getMessage();
                $payment->save();
                event(new PaymentPartiallyReceived($payment, $response->getAmountPaid()));
            } else {
                $payment->status = PaymentStatus::PAID();
                $payment->status_message = $response->getMessage();
                $payment->save();
                event(new PaymentCompleted($payment));
            }
        } else {
            $payment->status = PaymentStatus::DECLINED();
            $payment->status_message = $response->getMessage();
            $payment->save();
            event(new PaymentDeclined($payment));
        }

        return new SuccessResponseToNetopia();
    }
}
