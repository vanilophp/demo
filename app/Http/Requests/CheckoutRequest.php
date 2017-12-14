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
            'billpayer.firstname'  => 'required|min:2|max:255',
            'billpayer.lastname'  => 'required|min:2|max:255'
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
