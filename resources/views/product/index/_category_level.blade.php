@foreach($taxons as $taxon)
<div class="pl-{{$taxon->level}}">
    @if($taxon->children->count())
        <div class="dropdown-divider"></div>
        {{--<h6 class="dropdown-header">{{ $taxon->name }}</h6>--}}
        <a href="{{ route('product.category', [$taxon->taxonomy->slug, $taxon]) }}" class="dropdown-item dropdown-header">
            {{ $taxon->name }}
        </a>
        @include('product.index._category_level', ['taxons' => $taxon->children])
        <div class="dropdown-divider"></div>
    @else
        <a class="dropdown-item" href="{{ route('product.category', [$taxon->taxonomy->slug, $taxon]) }}">{{ $taxon->name }}</a>
    @endif
</div>
@endforeach
