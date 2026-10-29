@props(['products' => [], 'currentProductKey'])

<section class="da-product-collection da-recently-viewed" data-recently-viewed data-current-product="{{ $currentProductKey }}" aria-label="Recently viewed experiences">
    <div class="da-product-collection-heading">
        <h2>Recently <span>viewed</span></h2>
    </div>
    <p class="da-recently-viewed-empty" data-recently-viewed-empty>Open another experience to see it here.</p>
    <div class="da-product-preview-track" data-recently-viewed-list>
        @foreach ($products as $key => $recentProduct)
            @if ($key !== $currentProductKey)
                <x-desert-adventures.product-preview-card :product="$recentProduct" data-recent-product="{{ $key }}" hidden />
            @endif
        @endforeach
    </div>
</section>
