@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">All Products</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">Cart</a></li>
    <li class="breadcrumb-item">Checkout</li>
    <li class="breadcrumb-item">Order Complete</li>

@stop

@section('content')
    <div class="container">
        <h1>Wonderful {{ $order->getBillpayer()->firstname }}!</h1>
        <hr>

        <div class="alert alert-success">Your order has been registered with number
            <strong>{{ $order->getNumber() }}</strong>.
        </div>

        <h3>Next Steps</h3>

        <ol>
            <li>Your order will be prepared in the next 24 hours.</li>
            <li>Your package will be handed over to the courier.</li>
            <li>You'll receive an E-mail with the Shipment Information.</li>
        </ol>

        <div>
            <a href="{{ route('product.index') }}" class="btn btn-info">All right!</a>
        </div>

    </div>
@endsection
