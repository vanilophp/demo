<div id="shipping-address" v-show="!shipToBillingAddress">
    <h3>Shipping Address</h3>
    <hr>

    <div class="form-group row">

        <label class="col-form-label col-md-2">{{ __('Name') }}</label>
        <div class="col-md-10">
            {{ Form::text('shippingAddress[name]', null, [
                    'class' => 'form-control' . ($errors->has('shippingAddress.name') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('shippingAddress.name'))
                <div class="invalid-feedback">{{ $errors->first('shippingAddress.name') }}</div>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-md-2">{{ __('Country') }}</label>
        <div class="col-md-10">
            {{ Form::select('shippingAddress[country_id]', $countries->pluck('name', 'id'),
                    setting('appshell.default.country'), [
                    'class' => 'form-control' . ($errors->has('shippingAddress.country_id') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('shippingAddress.country_id'))
                <div class="invalid-feedback">{{ $errors->first('shippingAddress.country_id') }}</div>
            @endif
        </div>
    </div>

    <div class="form-group row">

        <label class="col-form-label col-md-2">{{ __('Address') }}</label>
        <div class="col-md-10">
            {{ Form::text('shippingAddress[address]', null, [
                    'class' => 'form-control' . ($errors->has('shippingAddress.address') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('shippingAddress.address'))
                <div class="invalid-feedback">{{ $errors->first('shippingAddress.address') }}</div>
            @endif
        </div>
    </div>

    <div class="form-group row">

        <label class="col-form-label col-md-2">{{ __('Zip code') }}</label>
        <div class="col-md-4">
            {{ Form::text('shippingAddress[postalcode]', null, [
                    'class' => 'form-control' . ($errors->has('shippingAddress.postalcode') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('shippingAddress.postalcode'))
                <div class="invalid-feedback">{{ $errors->first('shippingAddress.postalcode') }}</div>
            @endif
        </div>

        <label class="col-form-label col-md-2">{{ __('City') }}</label>
        <div class="col-md-4">
            {{ Form::text('shippingAddress[city]', null, [
                    'class' => 'form-control' . ($errors->has('shippingAddress.city') ? ' is-invalid' : '')
                ])
            }}
            @if ($errors->has('shippingAddress.city'))
                <div class="invalid-feedback">{{ $errors->first('shippingAddress.city') }}</div>
            @endif
        </div>

    </div>
</div>
