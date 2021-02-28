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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vanilo\Payment\Events\PaymentCompleted;
use Vanilo\Payment\Events\PaymentDeclined;
use Vanilo\Payment\Events\PaymentPartiallyReceived;
use Vanilo\Payment\Models\Payment;
use Vanilo\Payment\Models\PaymentStatus;
use Vanilo\Payment\PaymentGateways;

class EuplatescReturnController extends Controller
{
    public function frontend(Request $request)
    {
        $response = PaymentGateways::make('euplatesc')->processPaymentResponse($request);
        $payment = Payment::findByPaymentId($response->getPaymentId());

        if (!$payment) {
            abort(404);
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

        return view('payment.return_euplatesc', [
            'response' => $response,
            'payment' => $payment,
            'order' => $payment->getPayable()
        ]);
    }

    public function silent(Request $request)
    {
        Log::debug('Euplatesc silent return', $request->toArray());
    }
}
