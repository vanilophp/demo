<h3>Billing Address</h3>
<div class="form-group form-group-sm row{{ $errors->has('billpayer.address.country_id') ? ' has-danger' : '' }}">
    <label class="form-control-label col-md-2">{{ __('Country') }}</label>
    <div class="col-md-10">
        {{ Form::select('billpayer[address][country_id]', $countries->pluck('name', 'id'), 'NL', ['class' => 'form-control']) }}

        @if ($errors->has('billpayer.address.country_id'))
            <div class="form-control-feedback">{{ $errors->first('billpayer.address.country_id') }}</div>
        @endif
    </div>
</div>

<div class="form-group form-group-sm row{{ $errors->has('billpayer.address.address') ? ' has-danger' : '' }}">

    <label class="form-control-label col-md-2">{{ __('Address') }}</label>
    <div class="col-md-10">
        {{ Form::text('billpayer[address][address]', null, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group form-group-sm row{{ $errors->has('billpayer.address.postalcode') ? ' has-danger' : '' }}">

    <label class="form-control-label col-md-2">{{ __('Zip code') }}</label>
    <div class="col-md-4">
        {{ Form::text('billpayer[address][postalcode]', null, ['class' => 'form-control']) }}
    </div>

    <label class="form-control-label col-md-2">{{ __('City') }}</label>
    <div class="col-md-4">
        {{ Form::text('billpayer[address][city]', null, ['class' => 'form-control']) }}
    </div>

</div>

