<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vanilo\Payment\Models\Payment;
use Vanilo\Payment\PaymentGateways;
use Vanilo\Payment\Processing\PaymentResponseHandler;

class PaypalReturnController extends Controller
{
    public function return(Request $request)
    {
        Log::debug('PayPal confirmation', $request->toArray());

        $payment = $this->processPaymentResponse($request);

        return view('payment.return', [
            'payment'  => $payment,
            'order'    => $payment->getPayable()
        ]);
    }

    public function cancel(Request $request)
    {
        Log::debug('PayPal cancel', $request->toArray());

        $payment = $this->processPaymentResponse($request);

        return view('payment.return', [
            'payment' => $payment,
            'order'   => $payment->getPayable(),
        ]);
    }

    public function webhook(Request $request)
    {
        Log::debug('PayPal webhook', [
            'req' => $request->toArray(),
            'method' => $request->method(),
        ]);

        $this->processPaymentResponse($request);

        return new JsonResponse(['message' => 'Received OK']);
    }

    private function processPaymentResponse(Request $request): Payment
    {
        $response = PaymentGateways::make('paypal')->processPaymentResponse($request);
        $payment  = Payment::findByPaymentId($response->getPaymentId());

        if (!$payment) {
            throw new ModelNotFoundException('Could not locate payment with id ' . $response->getPaymentId());
        }

        $handler = new PaymentResponseHandler($payment, $response);
        $handler->writeResponseToHistory();
        $handler->updatePayment();
        $handler->fireEvents();

        return $payment;
    }
}
