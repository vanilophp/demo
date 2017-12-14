@extends('layouts.app')

@section('content')
    <style>
        .product-image {
            height: 45px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Shopping Cart</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(Cart::isEmpty())
                            <div class="alert alert-info">
                                Your cart is empty
                            </div>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">name</th>
                                        <th>price</th>
                                        <th>qty</th>
                                        <th>total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Cart::getItems() as $item)
                                        <tr>
                                            <td width="55"><img src="/images/product.jpg" class="product-image"/></td>
                                            <td>
                                                <a href="{{ route('shop.product', $item->product) }}">
                                                    {{ $item->product->getName() }}
                                                </a></td>
                                            <td>{{ format_price($item->price) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ format_price($item->total) }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove', $item) }}"
                                                      style="display: inline-block" method="post">
                                                    {{ csrf_field() }}
                                                    <button class="btn btn-link btn-sm"><span class="text-danger">&xotime;</span></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4"></th>
                                    <th>
                                        {{ format_price(Cart::total()) }}
                                    </th>
                                    <th></th>
                                </tr>
                                </tfoot>

                            </table>

                            <p class="text-right">
                                <a href="{{ route('shop.index') }}" class="btn btn-lg btn-link">Continue Shopping</a>
                                <a href="{{ route('checkout.show') }}" class="btn btn-lg btn-primary">Proceed To Checkout</a>
                            </p>

                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
