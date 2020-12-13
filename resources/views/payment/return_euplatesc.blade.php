@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">All Products</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">Cart</a></li>
    <li class="breadcrumb-item">Checkout</li>
    <li class="breadcrumb-item">Payment Complete</li>

@stop

@section('content')
    <div class="container">
        <h1>Payment Return</h1>
        <hr>

        @include('checkout._final_success_text')

        <?php dump($response) ?>
    </div>
@endsection
