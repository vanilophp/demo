@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">All Products</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">Cart</a></li>
    <li class="breadcrumb-item">Checkout</li>
    @if($response->wasSuccessful())
        <li class="breadcrumb-item">Payment Complete</li>
    @else
        <li class="breadcrumb-item">Payment Failed</li>
    @endif
@stop

@section('content')
    <div class="container">
        <h1>Payment Return</h1>
        <hr>

        @if($response->wasSuccessful())
            @include('checkout._final_success_text')
        @else
            <div class="alert alert-danger">
                <strong>Payment failed</strong><br>
                {{ $response->getMessage() }}
            </div>
        @endif

        <?php dump($payment) ?>

        <?php dump($order) ?>
    </div>
@endsection
