@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">All Products</a></li>
    <li class="breadcrumb-item">Cart</li>
@stop

@section('content')
    <style>
        .product-image {
            height: 45px;
        }
    </style>
    <div class="container">
        <h1>Shopping Cart</h1>
        <hr>

        @if(Cart::isEmpty())
            <div class="alert alert-info">
                Your cart is empty
            </div>
        @else
        <div class="row">
            <div class="col-md-8">
                <div class="card bg-light">
                    <div class="card-header">Items</div>

                    <div class="card-body">
                        <div class="rounded bg-white">
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th colspan="2">Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(Cart::getItems() as $item)
                                    <tr>
                                        <td width="55"><img src="{{ $item->product->getThumbnailUrl() ?: '/images/product.jpg' }}" class="product-image"/></td>
                                        <td>
                                            <a href="{{ route('product.show', $item->product) }}">
                                                {{ $item->product->getName() }}
                                            </a></td>
                                        <td>{{ format_price($item->price) }}</td>
                                        <td>
                                            <form class="form-inline" action="{{ route('cart.update', $item) }}" method="POST">
                                                @csrf
                                                <input type="text" name="qty" value="{{ $item->quantity }}" class="w-25" />
                                            </form>
                                        </td>
                                        <td>{{ format_price($item->total) }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove', $item) }}"
                                                  style="display: inline-block" method="post">
                                                {{ csrf_field() }}
                                                <button dusk="cart-delete-{{ $item->getBuyable()->id }}" class="btn btn-link btn-sm"><span class="text-danger">&xotime;</span></button>
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
                        </div>

                        <p>
                            <a href="{{ route('product.index') }}" class="btn-lg pl-0">Continue Shopping</a>
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-white">
                    <div class="card-header">Summary</div>
                    <div class="card-body">
                        @include('cart._summary')
                        <a href="{{ route('checkout.show') }}" class="btn btn-block btn-primary">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
