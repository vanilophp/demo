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
use Vanilo\Payment\Models\PaymentHistory;
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

        PaymentHistory::addPaymentResponse($payment, $response);

        $payment->status = $response->getStatus();
        $payment->amount_paid = $response->getAmountPaid();
        $payment->status_message = $response->getMessage();
        $payment->save();

        // Missing: firing events:
//                event(new PaymentPartiallyReceived($payment, $response->getAmountPaid()));
//                event(new PaymentCompleted($payment));
//            event(new PaymentDeclined($payment));

        return new SuccessResponseToNetopia();
    }
}
