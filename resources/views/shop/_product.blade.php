<article class="card shadow-sm">
    <a href="{{ route('shop.product', $product) }}">
        <img class="card-img-top"
        @if($product->hasImage())
            src="{{ $product->getThumbnailUrl() }}"
        @else
            src="/images/product.jpg"
        @endif
        alt="{{ $product->name }}" />
    </a>

    <div class="card-body">
        <h5><a href="{{ route('shop.product', $product) }}">{{ $product->name }}</a></h5>
        <p class="card-text">{{ format_price($product->price) }}</p>
    </div>
</article>
