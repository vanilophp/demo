@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">All Products</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">Cart</a></li>
    <li class="breadcrumb-item">Checkout</li>

@stop

@section('content')
    <style>
        .product-image {
            max-width: 100%;
            display: block;
            margin-bottom: 2em;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Checkout</div>

                    <div class="card-body">
                        @unless ($checkout)
                            <div class="alert alert-warning">
                                <p>Hey, nothing to check out here!</p>
                            </div>
                        @endunless

                        @if ($checkout)
                            <form id="checkout" action="{{ route('checkout.submit') }}" method="post">
                                {{ csrf_field() }}

                                @include('checkout._billpayer', ['billpayer' => $checkout->getBillPayer()])

                                <div class="mb-4">
                                    <input type="hidden" name="ship_to_billing_address" value="0" />
                                    <div class="form-check">
                                        <input class="form-check-input" id="chk_ship_to_billing_address" type="checkbox" name="ship_to_billing_address" value="1" v-model="shipToBillingAddress">
                                        <label class="form-check-label" for="chk_ship_to_billing_address">Ship to the same address</label>
                                    </div>
                                </div>

                                @include('checkout._shipping_address', ['address' => $checkout->getShippingAddress()])

                                <hr>

                                <div class="form-group">

                                    <label class="">{{ __('Order Notes') }}</label>
                                    {{ Form::textarea('notes', null, [
                                            'class' => 'form-control' . ($errors->has('notes') ? ' is-invalid' : ''),
                                            'rows' => 3
                                        ])
                                    }}
                                    @if ($errors->has('notes'))
                                        <div class="invalid-feedback">{{ $errors->first('notes') }}</div>
                                    @endif
                                </div>

                                <hr>

                                <div>
                                    <button class="btn btn-lg btn-success">Submit Order</button>
                                </div>


                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white">
                    <div class="card-header">Summary</div>
                    <div class="card-body">
                        @include('cart._summary')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($checkout)
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            new Vue({
                el: '#checkout',
                data: {
                    isOrganization: {{ old('billpayer.is_organization') ?: 0 }},
                    shipToBillingAddress: {{ old('ship_to_billing_address') ?? 1 }}
                }
            });
        });
    </script>
    @endif
@stop

