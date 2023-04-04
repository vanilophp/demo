<div class="row" x-data="masterProduct">
    <div class="col-md-6">
        <div class="mb-2">
            <img :src="selectedVariant.imageUrl" id="product-image" />
        </div>

        <div class="thumbnail-container">
            <template x-for="image in selectedVariant.images">
                <div class="thumbnail mr-1">
                    <img class="mw-100" :src="image.thumbnail"
                         @click="document.getElementById('product-image').setAttribute('src', image.medium)"
                    />
                </div>
            </template>
        </div>
    </div>

    <div class="col-md-6">
        <div>
            <h4>Variants</h4>
            <div>
            @foreach($product->variants as $variant)
                <button class="btn" :class="selectedId === {{$variant->id}} ? 'btn-primary' : 'btn-outline-dark'"
                        @click="selectedId = {{$variant->id}}">{{ $variant->name }}</button>
            @endforeach
            </div>

            <form :action="'{{ route('cart.add-variant', '0000') }}'.replace('0000', selectedId)" method="post" class="my-4" :disabled="null === selectedId">
                {{ csrf_field() }}

                <span class="mr-2 font-weight-bold text-primary btn-lg" x-text="selectedVariant.priceFmt">{{ format_price($product->price) }}</span>
                <button type="submit" class="btn btn-success btn-lg" :disabled="null === selectedId">Add to cart</button>
            </form>

            <hr>
            <p class="text-secondary" x-html="selectedVariant.description"></p>
            <hr>
        </div>
    </div>
</div>

@push('alpine')
    <script>
      document.addEventListener("alpine:init", () => {
        Alpine.data('masterProduct', () => ({
          selectedId: {{$product->variants->first()->id}},
          variants: {
            @foreach($product->variants as $variant)
              "{{$variant->id}}": {
                name: "{{$variant->name}}",
                price: {{$variant->price}},
                originalPrice: {{$variant->original_price}},
                priceFmt: "{{ format_price($variant->price) }}",
                originalPriceFmt: "{{ format_price($variant->original_price) }}",
                description: "{{ nl2br($variant->description ?? $product->description) }}",
                imageUrl: "{{ $variant->getImageUrl('medium') ?: ($product->getImageUrl('medium') ?: '/images/product-medium.jpg') }}",
                images: [
                  @forelse($variant->getMedia() as $media)
                    { medium: "{{ $media->getUrl('medium') }}", thumbnail: "{{ $media->getUrl('thumbnail') }}" },
                  @empty
                    { medium: "{{ $product->getImageUrl('medium') ?: '/images/product-medium.jpg' }}", thumbnail: "{{ $product->getImageUrl('thumbnail') ?: '/images/product.jpg' }}" },
                  @endforelse
                ]
              },
            @endforeach
          },
          get selectedVariant() {
            return this.selectedId ? this.variants[this.selectedId] : {priceFmt: '{{format_price($product->price)}}'};
          },
        }))
      });
    </script>
@endpush

