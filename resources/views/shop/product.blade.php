@extends('layouts.app')

@section('content')
    <style>
        .product-image {
            max-width: 100%;
            display: block;
            margin-bottom: 2em;
        }

        .product-price {
            margin-bottom: .35em;
        }

        .price {
            font-size: 1.35em;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $product->name }}</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <img src="/images/product.jpg" class="product-image" />

                        <p>{{ $product->description }}</p>

                        <form action="{{ route('cart.add', $product) }}" method="post">
                            {{ csrf_field() }}

                            <div class="product-price">
                                <span class="price">{{ format_price($product->price) }}</span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Add to cart</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
