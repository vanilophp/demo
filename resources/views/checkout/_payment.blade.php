<div id="payment" class="mb-4">
    <h3>Payment Method</h3>
    <hr>

    <div class="form-group row">

        <div class="col-md-11 offset-md-1">
        @forelse($paymentMethods as $paymentMethod)
            <div class="form-check">
                {{ Form::radio('paymentMethod', $paymentMethod->id, false, [
                        'class' => 'form-check-input' . ($errors->has('paymentMethod') ? ' is-invalid' : ''),
                        'id' => 'payment_method_' . $paymentMethod->id
                    ])
                }}
                <label class="form-check-label" for="{{ 'payment_method_' . $paymentMethod->id }}">
                    {{ $paymentMethod->name }}
                </label>
            </div>
        @empty
        @endforelse
        </div>

        @if ($errors->has('paymentMethod'))
            <div class="col-12 mt-2">
                <div class="alert alert-danger">{{ $errors->first('paymentMethod') }}</div>
            </div>
        @endif
    </div>
</div>

