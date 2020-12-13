<?php

declare(strict_types=1);

/**
 * Contains the EuplatescController class.
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

class EuplatescController extends Controller
{
    public function paymentReturn(Request $request)
    {
        return view('payment.return_euplatesc', ['response' => $request]);
    }

    public function silentReturn(Request $request)
    {
        Log::debug('Euplatesc silent return', $request->toArray());
    }
}
