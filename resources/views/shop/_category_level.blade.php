@foreach($taxons as $taxon)
<div>
    @if($taxon->children->count())

        <div class="btn-group dropright">
            <a href="{{ route('shop.category', [$taxon->taxonomy->slug, $taxon]) }}" class="btn btn-link">
                {{ $taxon->name }}
            </a>
            <button type="button" class="btn btn-link dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropright</span>
            </button>
            <div class="dropdown-menu">
                @foreach($taxon->children as $child)
                    <a class="dropdown-item" href="{{ route('shop.category', [$child->taxonomy->slug, $child]) }}">{{ $child->name }}</a>
                @endforeach
            </div>
        </div>
    @else
        <a class="btn btn-link" href="{{ route('shop.category', [$taxon->taxonomy->slug, $taxon]) }}">{{ $taxon->name }}</a>
    @endif
</div>
@endforeach
