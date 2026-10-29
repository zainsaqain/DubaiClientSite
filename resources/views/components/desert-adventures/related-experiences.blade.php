@props(['products' => []])

@if (collect($products)->isNotEmpty())
    <section class="da-product-collection da-related" data-related-carousel aria-label="Other experiences you might like">
        <div class="da-product-collection-heading">
            <h2>Other <span>experiences</span> you might like</h2>
            <div class="da-carousel-controls">
                <button type="button" data-carousel-previous aria-label="Show previous experiences">
                    <svg width="10" height="16" viewBox="0 0 10 16" fill="none" aria-hidden="true"><path d="M8.5 1.5L2 8L8.5 14.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button type="button" data-carousel-next aria-label="Show next experiences">
                    <svg width="10" height="16" viewBox="0 0 10 16" fill="none" aria-hidden="true"><path d="M1.5 1.5L8 8L1.5 14.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>
        <div class="da-product-preview-track" data-carousel-track tabindex="0">
            @foreach ($products as $related)
                <x-desert-adventures.product-preview-card :product="$related" />
            @endforeach
        </div>
    </section>
@endif
