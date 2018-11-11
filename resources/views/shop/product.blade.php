@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    @if ($product->taxons->count())
        @include('shop._breadcrumbs', ['taxon' => $product->taxons->first()])
    @endif
    <li class="breadcrumb-item">{{ $product->name }}</li>
@stop

@section('content')
    <style>
        .thumbnail-container {
            overflow-x: scroll;
        }

        .thumbnail {
            width: 64px;
            height: auto;
            display: block;
            float: left;
        }

        .thumbnail img {
            cursor: pointer;
        }
    </style>
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-2">
                    <?php $img = $product->getMedia()->first() ? $product->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' ?>
                    <img src="{{ $img  }}" id="product-image" />
                </div>

                <div class="thumbnail-container">
                    @foreach($product->getMedia() as $media)
                        <div class="thumbnail mr-1">
                            <img class="mw-100" src="{{ $media->getUrl('thumbnail') }}"
                                 onclick="document.getElementById('product-image').setAttribute('src', '{{ $media->getUrl("medium") }}')"
                            />
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6">
                <form action="{{ route('cart.add', $product) }}" method="post" class="mb-4">
                    {{ csrf_field() }}

                    <span class="mr-2 font-weight-bold text-primary btn-lg">{{ format_price($product->price) }}</span>
                    <button type="submit" class="btn btn-success btn-lg" @if(!$product->price) disabled @endif>Add to cart</button>
                </form>

                <hr>

                <p class="text-secondary">{{ $product->description }}</p>

                <hr>

            </div>
        </div>
    </div>
@endsection
