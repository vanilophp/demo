<div id="shipping-address" v-show="!shipToBillingAddress">
    <h3>Shipping Address</h3>

    <div class="form-group form-group-sm row{{ $errors->has('shippingAddress.name') ? ' has-danger' : '' }}">

        <label class="form-control-label col-md-2">{{ __('Name') }}</label>
        <div class="col-md-10">
            {{ Form::text('shippingAddress[name]', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group form-group-sm row{{ $errors->has('shippingAddress.country_id') ? ' has-danger' : '' }}">
        <label class="form-control-label col-md-2">{{ __('Country') }}</label>
        <div class="col-md-10">
            {{ Form::select('shippingAddress[country_id]', $countries->pluck('name', 'id'), 'NL', ['class' => 'form-control']) }}

            @if ($errors->has('shippingAddress.country_id'))
                <div class="form-control-feedback">{{ $errors->first('shippingAddress.country_id') }}</div>
            @endif
        </div>
    </div>

    <div class="form-group form-group-sm row{{ $errors->has('shippingAddress.address') ? ' has-danger' : '' }}">

        <label class="form-control-label col-md-2">{{ __('Address') }}</label>
        <div class="col-md-10">
            {{ Form::text('shippingAddress[address]', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group form-group-sm row{{ $errors->has('shippingAddress.postalcode') ? ' has-danger' : '' }}">

        <label class="form-control-label col-md-2">{{ __('Zip code') }}</label>
        <div class="col-md-4">
            {{ Form::text('shippingAddress[postalcode]', null, ['class' => 'form-control']) }}
        </div>

        <label class="form-control-label col-md-2">{{ __('City') }}</label>
        <div class="col-md-4">
            {{ Form::text('shippingAddress[city]', null, ['class' => 'form-control']) }}
        </div>

    </div>
</div>
