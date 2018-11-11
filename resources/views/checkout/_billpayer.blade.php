<h3>Bill To</h3>
<hr>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::text('billpayer[firstname]', null, [
                    'class' => 'form-control' . ($errors->has('billpayer.firstname') ? ' is-invalid' : ''),
                    'placeholder' => __('First name')
                ])
            }}

            @if ($errors->has('billpayer.firstname'))
                <div class="invalid-feedback">{{ $errors->first('billpayer.firstname') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {{ Form::text('billpayer[lastname]', null, [
                    'class' => 'form-control' . ($errors->has('billpayer.lastname') ? ' is-invalid' : ''),
                    'placeholder' => __('Last name')
                ])
            }}

            @if ($errors->has('billpayer.lastname'))
                <div class="invalid-feedback">{{ $errors->first('billpayer.lastname') }}</div>
            @endif
        </div>
    </div>

</div>


<div class="form-group">
    <div class="form-check">
        <input class="form-check-input" id="chk_is_organization" type="checkbox"
               name="billpayer[is_organization]" value="1" v-model="isOrganization">
        <label class="form-check-label" for="chk_is_organization">{{ __('Bill to Company') }}</label>
    </div>
</div>

<div id="billpayer-organization" v-show="isOrganization">
    <div class="form-group">
        {{ Form::text('billpayer[company_name]', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('billpayer.company_name') ? ' is-invalid' : ''),
                'placeholder' => __('Company name')
             ])
        }}
        @if ($errors->has('billpayer.company_name'))
            <div class="invalid-feedback">{{ $errors->first('billpayer.company_name') }}</div>
        @endif
    </div>

    <div class="form-group">
        {{ Form::text('billpayer[tax_nr]', null, [
                'class' => 'form-control' . ($errors->has('billpayer.tax_nr') ? ' is-invalid' : ''),
                'placeholder' => __('Tax no.')
            ])
        }}
        @if ($errors->has('billpayer.tax_nr'))
            <div class="invalid-feedback">{{ $errors->first('billpayer.tax_nr') }}</div>
        @endif
    </div>
</div>

@include('checkout._billing_address', ['address' => $billpayer->getBillingAddress()])

