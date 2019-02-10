<article class="card shadow-sm">
    <div class="card-body">
        <h5><a href="{{ route('product.category', [$taxon->taxonomy->name, $taxon]) }}">{{ $taxon->name }}</a></h5>
    </div>
</article>
