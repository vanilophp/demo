<article class="card shadow-sm"
         style="background-image: url('{{ $taxon->getImageUrl('card') }}'); min-height: 135px">
    <div class="card-body">
        <h5 style="text-shadow: #333 0 0 12px"><a class="text-light"
                href="{{ route('product.category', [$taxon->taxonomy->name, $taxon]) }}">{{ $taxon->name }}</a>
        </h5>
    </div>
</article>
