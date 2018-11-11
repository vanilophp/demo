<h3>Billing Address</h3>
<hr>

<div class="form-group row">
    <label class="col-form-label col-md-2">{{ __('Country') }}</label>
    <div class="col-md-10">
        {{ Form::select('billpayer[address][country_id]', $countries->pluck('name', 'id'),
                setting('appshell.default.country'), [
                'class' => 'form-control' . ($errors->has('billpayer.address.country_id') ? ' is-invalid' : '')
            ])
        }}

        @if ($errors->has('billpayer.address.country_id'))
            <div class="invalid-feedback">{{ $errors->first('billpayer.address.country_id') }}</div>
        @endif
    </div>
</div>

<div class="form-group row">

    <label class="col-form-label col-md-2">{{ __('Address') }}</label>
    <div class="col-md-10">
        {{ Form::text('billpayer[address][address]', null, [
                'class' => 'form-control' . ($errors->has('billpayer.address.address') ? ' is-invalid' : '')
            ])
        }}
        @if ($errors->has('billpayer.address.address'))
            <div class="invalid-feedback">{{ $errors->first('billpayer.address.address') }}</div>
        @endif
    </div>
</div>

<div class="form-group row">

    <label class="col-form-label col-md-2">{{ __('Zip code') }}</label>
    <div class="col-md-4">
        {{ Form::text('billpayer[address][postalcode]', null, [
                'class' => 'form-control' . ($errors->has('billpayer.address.postalcode') ? ' is-invalid' : '')
            ])
        }}
        @if ($errors->has('billpayer.address.postalcode'))
            <div class="invalid-feedback">{{ $errors->first('billpayer.address.postalcode') }}</div>
        @endif
    </div>

    <label class="col-form-label col-md-2">{{ __('City') }}</label>
    <div class="col-md-4">
        {{ Form::text('billpayer[address][city]', null, [
                'class' => 'form-control' . ($errors->has('billpayer.address.city') ? ' is-invalid' : '')
            ])
        }}
        @if ($errors->has('billpayer.address.city'))
            <div class="invalid-feedback">{{ $errors->first('billpayer.address.city') }}</div>
        @endif
    </div>

</div>

