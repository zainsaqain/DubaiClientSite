@props(['products' => []])

@if (collect($products)->isNotEmpty())
    <section class="da-product-collection da-related" data-related-carousel aria-label="Other experiences you might like">
        <div class="da-product-collection-heading"><h2>Other <span>experiences</span> you might like</h2><div><button type="button" data-carousel-previous aria-label="Show previous experiences">←</button><button type="button" data-carousel-next aria-label="Show next experiences">→</button></div></div>
        <div class="da-product-preview-track" data-carousel-track tabindex="0">
            @foreach ($products as $related)<x-desert-adventures.product-preview-card :product="$related" />@endforeach
        </div>
    </section>
@endif
