<?php

declare(strict_types=1);

/**
 * Contains the AdyenController class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-08-03
 *
 */

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vanilo\Payment\Models\Payment;
use Vanilo\Payment\PaymentGateways;
use Vanilo\Payment\Processing\PaymentResponseHandler;

class AdyenController extends Controller
{
    public function submit(Request $request, string $paymentId)
    {
        $gateway = PaymentGateways::make('adyen');
        $payment = Payment::findByPaymentId($paymentId);

        return $gateway->submitPaymentToAdyen($payment, $request->paymentMethod);
    }

    public function webhook(Request $request)
    {
        Log::debug('Adyen Webhook Received', ['payload' => $request->json()->all()]);
        $response = PaymentGateways::make('adyen')->processPaymentResponse($request);
        $payment  = Payment::findByPaymentId($response->getPaymentId());

        if (!$payment) {
            throw new ModelNotFoundException('Could not locate payment with id ' . $response->getPaymentId());
        }

        $handler = new PaymentResponseHandler($payment, $response);
        $handler->writeResponseToHistory();
        $handler->updatePayment();
        $handler->fireEvents();

        // @see https://docs.adyen.com/development-resources/webhooks#accept-notifications
        return response('[accepted]', 200, ['Content-type' => 'text/plain']);
    }
}
