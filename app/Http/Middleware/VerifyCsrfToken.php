<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/payment/eup/*',
        '/payment/netopia/*',
        '/payment/paypal/*',
        '/payment/adyen/*',
        '/payment/stripe/*',
        '/payment/simplepay/*',
        '/payment/braintree/*',
        '/payment/mollie/*',
    ];
}
