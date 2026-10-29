@props(['product'])

<a class="da-product-preview-card" href="{{ route($product['route']) }}">
    <img src="{{ asset($product['gallery'][0]) }}" alt="{{ $product['title'] }}" loading="lazy">
    <span class="da-product-preview-category">{{ $product['category'] }}</span>
    <strong>{{ $product['title'] }}</strong>
    <div class="da-product-preview-badges">
        @foreach (array_slice($product['badges'] ?? [], 0, 2) as $badge)<b>{{ $badge }}</b>@endforeach
        <span>⌖ {{ $product['location'] }}</span>
    </div>
    <em>Sample from AED {{ number_format($product['booking']['base_price']) }}</em>
</a>
