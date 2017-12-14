@extends('layouts.app')

@section('content')
    <style>
        .product {
            margin-bottom: 1.35em;
        }

        .product h5 {
            margin-bottom: 0;
        }

        .product a h5 {
            text-decoration: none;
        }

        .product img {
            max-width: 100%;
            display: block;
        }

        .product-attrs {
            margin-top: 0;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Product List</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">

                            @foreach($products as $product)
                                <article class="col-xs-12 col-sm-6 col-md-4 product">
                                    <a href="{{ route('shop.product', $product) }}">
                                        <img src="/images/product.jpg"/>
                                        <h5>{{ $product->name }}</h5>
                                    </a>
                                    <div class="product-attrs">
                                        <span class="price">{{ format_price($product->price) }}</span>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
