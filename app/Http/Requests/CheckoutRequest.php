<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Payment\Models\PaymentMethod;

class CheckoutRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'billpayer.firstname' => 'required|min:2|max:255',
            'billpayer.lastname'  => 'required|min:2|max:255',
            'billpayer.company_name' => 'required_if:billpayer.is_organization,1',
            'billpayer.address.address' => 'required|min:2|max:255',
            'shippingAddress.address' => 'required_unless:ship_to_billing_address,1',
            'paymentMethod' => 'required|exists:payment_methods,id'
        ];
    }

    public function paymentMethod(): PaymentMethod
    {
        return PaymentMethod::find($this->get('paymentMethod'));
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}
