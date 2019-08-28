<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Konekt\Address\Models\CountryProxy;
use Vanilo\Cart\Contracts\Cart;
use Vanilo\Checkout\Contracts\Checkout;
use Vanilo\Order\Contracts\OrderFactory;

class CheckoutController extends Controller
{
    /** @var Checkout */
    private $checkout;

    /** @var Cart */
    private $cart;

    public function __construct(Checkout $checkout, Cart $cart)
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
            'checkout'  => $checkout,
            'countries' => CountryProxy::all()
        ]);
    }

    public function submit(CheckoutRequest $request, OrderFactory $orderFactory)
    {
        $this->checkout->update($request->all());
        $this->checkout->setCart(Cart::model());

        $order = $orderFactory->createFromCheckout($this->checkout);
        $this->cart->destroy();

        return view('checkout.thankyou', ['order' => $order]);
    }

}
