<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Konekt\Address\Models\CountryProxy;
use Vanilo\Cart\Contracts\CartManager;
use Vanilo\Checkout\Contracts\Checkout;
use Vanilo\Foundation\Models\Cart;
use Vanilo\Order\Contracts\OrderFactory;
use Vanilo\Foundation\Models\Order;
use Vanilo\Payment\Factories\PaymentFactory;
use Vanilo\Payment\Models\PaymentHistory;
use Vanilo\Payment\Models\PaymentMethod;

class CheckoutController extends Controller
{
    /** @var Checkout */
    private $checkout;

    /** @var Cart */
    private $cart;

    public function __construct(Checkout $checkout, CartManager $cart)
    {
        $this->checkout = $checkout;
        $this->cart     = $cart;
    }

    public function show()
    {
        $checkout = false;

        if ($this->cart->isNotEmpty()) {
            $checkout = $this->checkout;
            if ($old = old()) {
                $checkout->update($old);
            }

            $checkout->setCart($this->cart);
        }

        return view('checkout.show', [
            'checkout' => $checkout,
            'countries' => CountryProxy::all(),
            'paymentMethods' => PaymentMethod::actives()->get(),
        ]);
    }

    public function submit(CheckoutRequest $request, OrderFactory $orderFactory)
    {
        $this->checkout->update($request->all());
        $this->checkout->setCustomAttribute('notes', $request->get('notes'));
        $this->checkout->setCart($this->cart);

        /** @var Order $order */
        $order = $orderFactory->createFromCheckout($this->checkout);
        $order->notes = $request->get('notes');
        $order->save();
        $this->cart->destroy();

        $paymentMethod = $request->paymentMethod();
        $payment = PaymentFactory::createFromPayable($order, $paymentMethod);
        PaymentHistory::begin($payment);
        $paymentRequest = $paymentMethod
            ->getGateway()
            ->createPaymentRequest($payment, options: ['webhookUrl' => route('payment.mollie.webhook'), 'redirectUrl' => route('payment.mollie.return', $payment->hash)]);

        // @todo the method exists check can be removed after v4 upgrade
        if (method_exists($paymentRequest, 'getRemoteId') && $paymentRequest->getRemoteId()) {
            $payment->update([
                'remote_id' => $paymentRequest->getRemoteId(),
            ]);
        }

        return view('checkout.thankyou', [
            'order' => $order,
            'paymentRequest' => $paymentRequest,
        ]);
    }
}
