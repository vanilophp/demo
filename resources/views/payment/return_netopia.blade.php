@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">All Products</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">Cart</a></li>
    <li class="breadcrumb-item">Checkout</li>

@stop

@section('content')
    <div class="container">
        <h1>Payment Return</h1>

        <hr>

        <?php dump($payment) ?>

        <?php dump($order) ?>
    </div>
@endsection
