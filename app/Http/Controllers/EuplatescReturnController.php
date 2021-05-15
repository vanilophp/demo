<?php

declare(strict_types=1);

/**
 * Contains the EuplatescReturnController class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-12-13
 *
 */

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vanilo\Payment\Models\Payment;
use Vanilo\Payment\PaymentGateways;
use Vanilo\Payment\Processing\PaymentResponseHandler;

class EuplatescReturnController extends Controller
{
    public function frontend(Request $request)
    {
        $response = PaymentGateways::make('euplatesc')->processPaymentResponse($request);
        $payment = Payment::findByPaymentId($response->getPaymentId());

        if (!$payment) {
            abort(404);
        }

        return view('payment.return', [
            'payment' => $payment,
            'order' => $payment->getPayable()
        ]);
    }

    public function silent(Request $request)
    {
        Log::debug('Euplatesc silent return', $request->toArray());

        $response = PaymentGateways::make('euplatesc')->processPaymentResponse($request);
        $payment = Payment::findByPaymentId($response->getPaymentId());

        if (!$payment) {
            // Euplatesc doesn't specify requirements for
            // merchant HTTP responses. Therefore, any
            // other format is allowed XML/TXT, etc
            return new JsonResponse([
                'message' => 'Could not locate payment',
                'payment_id' => $response->getPaymentId()
            ], 404);
        }

        $handler = new PaymentResponseHandler($payment, $response);
        $handler->writeResponseToHistory();
        $handler->updatePayment();
        $handler->fireEvents();

        // Response format is arbitrary but it must have HTTP 200 status code on success
        return new JsonResponse([
            'message' => 'Response processed successfully',
            'payment_id' => $response->getPaymentId()
        ]);
    }
}
