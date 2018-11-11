<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

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
            'shippingAddress.address' => 'required_unless:ship_to_billing_address,1'
        ];
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}
