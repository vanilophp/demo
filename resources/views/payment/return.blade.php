@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">All Products</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">Cart</a></li>
    <li class="breadcrumb-item">Checkout</li>
    <li class="breadcrumb-item">Payment</li>

@stop

@section('content')
    <div class="container">
        <h1>Payment of Order {{ $order->getNumber() }}</h1>

        @if(isset($response))
            @if ($response->getReturnStatus()->isSuccess())
                <div class="alert alert-success">
                    Your payment for order <strong>{{ $order->getNumber() }}</strong> was successful.
                </div>
            @elseif ($response->getReturnStatus()->isFail())
                <div class="alert alert-danger">
                    Payment for order <strong>{{ $order->getNumber() }}</strong> has been declined.
                </div>
            @elseif ($response->getReturnStatus()->isTimeout())
                <div class="alert alert-danger">
                    Payment for order <strong>{{ $order->getNumber() }}</strong> has timed out.
                </div>
            @elseif ($response->getReturnStatus()->isCancel())
                <div class="alert alert-info">
                    Payment for order <strong>{{ $order->getNumber() }}</strong> has been canceled.
                </div>
            @endif
        @else
            @if($payment->getStatus()->isPaid() || $payment->getStatus()->isAuthorized())
                <div class="alert alert-success">
                    Your payment for order <strong>{{ $order->getNumber() }}</strong> was successful:
                    <em>{{ $payment->status_message }}</em>
                </div>
            @elseif($payment->getStatus()->isPending())
                <div class="alert alert-info">
                    Payment for order <strong>{{ $order->getNumber() }}</strong> is being processed
                    @if(null !== $payment->status_message)
                        <div>Last known status is: <em>{{ $payment->status_message }}</em></div>
                    @endif
                </div>
            @elseif($payment->getStatus()->isOnHold())
                <div class="alert alert-warning">
                    Payment for order <strong>{{ $order->getNumber() }}</strong> has been accepted
                    but the transaction requires additional security checks to complete.
                    @if(null !== $payment->status_message)
                        <div><em>{{ $payment->status_message }}</em></div>
                    @endif
                </div>
            @elseif($payment->getStatus()->isDeclined())
                <div class="alert alert-danger">
                    Payment for order <strong>{{ $order->getNumber() }}</strong> has been declined:
                    <em>{{ $payment->status_message }}</em>
                </div>
            @elseif($payment->getStatus()->isTimeout())
                <div class="alert alert-danger">
                    Payment for order <strong>{{ $order->getNumber() }}</strong> has timed out.
                    <em>{{ $payment->status_message }}</em>
                </div>
            @else
                <div class="alert alert-warning">
                    Payment status for order <strong>{{ $order->getNumber() }}</strong> is:
                    <strong>{{ $payment->getStatus()->label() }}</strong>
                    @if(null !== $payment->status_message)
                        <div>The last known status message is: <em>{{ $payment->status_message }}</em></div>
                    @endif
                </div>
            @endif

            @if($payment->getStatus()->isPaid()|| $payment->getStatus()->isAuthorized())
                <h2>Next Steps</h2>
                <p>Your order has been registered and the products will be handed over to shipping within 24 hours.</p>
            @endif
        @endif
    </div>
@endsection
