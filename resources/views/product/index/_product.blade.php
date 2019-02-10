<article class="card shadow-sm">
    <a href="{{ route('product.show', $product) }}">
        <img class="card-img-top"
        @if($product->hasImage())
            src="{{ $product->getThumbnailUrl() }}"
        @else
            src="/images/product.jpg"
        @endif
        alt="{{ $product->name }}" />
    </a>

    <div class="card-body">
        <h5><a href="{{ route('product.show', $product) }}">{{ $product->name }}</a></h5>
        <p class="card-text">{{ format_price($product->price) }}</p>
    </div>
</article>
