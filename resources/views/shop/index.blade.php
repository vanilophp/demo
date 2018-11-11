@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    @if($taxon)
        @include('shop._breadcrumbs')
    @else
        <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">All Products</a></li>
    @endif
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                @foreach($taxonomies as $taxonomy)
                <div class="card card-default mb-3">
                    <div class="card-header">{{ $taxonomy->name }}</div>
                    <div class="card-body">
                        @include('shop._category_level', ['taxons' => $taxonomy->rootLevelTaxons()])
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-md-8">
                @if($taxon && $products->isEmpty() && $taxon->children->count())
                    <div class="card card-default mb-4">
                        <div class="card-header">{{ $taxon->name }} Subcategories</div>

                        <div class="card-body">
                            <div class="row">
                            @foreach($taxon->children as $child)
                                <div class="col-12 col-sm-6 col-md-4 mb-4">
                                    @include('shop._category', ['taxon' => $child])
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(!$products->isEmpty())
                <div class="card card-default">
                    <div class="card-header">{{ $taxon ?  'Products in ' . $taxon->name : 'All Products' }}</div>

                    <div class="card-body">
                        <div class="row">

                            @foreach($products as $product)
                                <div class="col-12 col-sm-6 col-md-4 mb-4">
                                    @include('shop._product')
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
