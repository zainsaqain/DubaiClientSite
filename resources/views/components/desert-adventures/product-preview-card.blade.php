@props(['product'])

@if ($product instanceof \App\Models\Tour)
    @php
        $tourImage = $product->images->sortBy('display_order')->first()?->path ?: ($product->main_image ?: $product->thumbnail);
        $tourPrice = $product->prices->where('is_active', true)->min('adult_price') ?? $product->starting_price;
        $tourCurrency = $product->prices->where('is_active', true)->first()?->currency ?: $product->currency;
    @endphp
    <a {{ $attributes->merge(['class' => 'da-product-preview-card']) }} href="{{ route('tours.show', $product) }}">
        <div class="da-product-preview-image">
            <img src="{{ $product->imageUrl($tourImage) }}" alt="{{ $product->image_alt ?: $product->name }}" loading="lazy">
        </div>
        <span class="da-product-preview-category">{{ $product->subcategory?->name ?: $product->category?->name }}</span>
        <strong>{{ $product->name }}</strong>
        <div class="da-product-preview-badges">
            @if ($product->is_bestseller)<b>Bestseller</b>@endif
            @if ($product->is_travellers_choice)<b>Travellers' Choice</b>@endif
            @if ($product->location_badge ?: $product->location)<span>⌖ {{ $product->location_badge ?: $product->location }}</span>@endif
        </div>
        <em>From <strong>{{ $tourCurrency }} {{ number_format((float) $tourPrice) }}</strong> <span>per person</span></em>
    </a>
@else
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
@endif
