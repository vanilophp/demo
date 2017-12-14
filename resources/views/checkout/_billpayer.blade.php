<h3>Bill To</h3>

<div class="row">
    <div class="col-md-6">
        <div class="form-group form-group-sm{{ $errors->has('billpayer.firstname') ? ' has-danger' : '' }}">
            {{ Form::text('billpayer[firstname]', null, [
                    'class' => 'form-control form-control-lg',
                    'placeholder' => __('First name')
                ])
            }}

            @if ($errors->has('billpayer.firstname'))
                <div class="form-control-feedback">{{ $errors->first('billpayer.firstname') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group form-group-sm{{ $errors->has('billpayer.lastname') ? ' has-danger' : '' }}">
            {{ Form::text('billpayer[lastname]', null, [
                    'class' => 'form-control form-control-lg',
                    'placeholder' => __('Last name')
                ])
            }}

            @if ($errors->has('billpayer.lastname'))
                <div class="form-control-feedback">{{ $errors->first('billpayer.lastname') }}</div>
            @endif
        </div>
    </div>

</div>


<div class="form-group form-group-sm{{ $errors->has('type') ? ' has-danger' : '' }}">
    <div class="checkbox">
        <label>
            {{ Form::checkbox('billpayer[is_organization]', 1, null, [
                'v-model' => 'isOrganization'
                ])
            }}
            {{ __('Bill to Company') }}
        </label>
    </div>

    @if ($errors->has('type'))
        <div class="form-control-feedback">{{ $errors->first('type') }}</div>
    @endif
</div>

<div id="billpayer-organization" v-show="isOrganization">
    <div class="form-group form-group-sm{{ $errors->has('billpayer.company_name') ? ' has-danger' : '' }}">
        {{ Form::text('billpayer[company_name]', null, ['class' => 'form-control form-control-lg', 'placeholder' => __('Company name')]) }}
        @if ($errors->has('billpayer.company_name'))
            <div class="form-control-feedback">{{ $errors->first('billpayer.company_name') }}</div>
        @endif
    </div>

    <div class="form-group form-group-sm{{ $errors->has('billpayer.tax_nr') ? ' has-danger' : '' }}">
        {{ Form::text('billpayer[tax_nr]', null, ['class' => 'form-control', 'placeholder' => __('Tax no.')]) }}
        @if ($errors->has('billpayer.tax_nr'))
            <div class="form-control-feedback">{{ $errors->first('billpayer.tax_nr') }}</div>
        @endif
    </div>
</div>

@include('checkout._billing_address', ['address' => $billpayer->getBillingAddress()])

