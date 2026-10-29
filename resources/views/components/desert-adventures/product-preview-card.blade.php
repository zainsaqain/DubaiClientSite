@props(['product'])

<a {{ $attributes->merge(['class' => 'da-product-preview-card']) }} href="{{ route($product['route']) }}">
    <div class="da-product-preview-image">
        <img src="{{ asset($product['gallery'][0]) }}" alt="{{ $product['title'] }}" loading="lazy">
    </div>
    <span class="da-product-preview-category">{{ $product['category'] }}</span>
    <strong>{{ $product['title'] }}</strong>
    <div class="da-product-preview-badges">
        @foreach (array_slice($product['badges'] ?? [], 0, 2) as $badge)<b>{{ $badge }}</b>@endforeach
        <span>⌖ {{ $product['location'] }}</span>
    </div>
    <em>From <strong>AED {{ number_format($product['booking']['base_price']) }}</strong> <span>per person</span></em>
</a>
