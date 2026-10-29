@props(['product'])

@php
    $products = config('adventure-products');
    $relatedProducts = collect($product['related'] ?? [])
        ->map(static fn (string $key) => $products[$key] ?? null)
        ->filter();
    $mainImage = $product['gallery'][0];
    $mainAlt = $product['gallery_alt'][0] ?? $product['title'];
@endphp

<section class="da-product-page da-container" data-product-detail>
    <x-breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Desert Adventures', 'url' => route('desert-adventures')],
        ['label' => $product['category'], 'url' => route($product['category_route'])],
        ['label' => $product['title']],
    ]" />

    <div class="da-product-heading">
        <div>
            <span>{{ $product['category'] }} · {{ $product['location'] }}</span>
            <h1>{{ $product['title'] }}</h1>
            <p>By Waheed Murad Tourism</p>
        </div>
        @if (count($product['badges']))
            <div class="da-product-awards" aria-label="Experience badges">
                @foreach ($product['badges'] as $badge)<span>{{ $badge }}</span>@endforeach
            </div>
        @endif
    </div>

    <div class="da-product-gallery" data-product-gallery>
        <figure class="da-gallery-main"><img src="{{ asset($mainImage) }}" alt="{{ $mainAlt }}" loading="eager" data-gallery-main><figcaption>Experience preview</figcaption></figure>
        @foreach (array_slice($product['gallery'], 1, 2) as $index => $image)
            <figure><img src="{{ asset($image) }}" alt="{{ $product['gallery_alt'][$index + 1] ?? $product['title'] }}" loading="lazy">@if ($loop->last)<button type="button" data-gallery-show-all>View photos</button>@endif</figure>
        @endforeach
    </div>
    <div class="da-gallery-thumbnails" aria-label="Product image gallery">
        @foreach ($product['gallery'] as $index => $image)
            <button type="button" data-gallery-thumbnail data-image="{{ asset($image) }}" data-alt="{{ $product['gallery_alt'][$index] ?? $product['title'] }}" aria-label="Show photo {{ $index + 1 }} of {{ $product['title'] }}" @if ($loop->first) aria-pressed="true" @else aria-pressed="false" @endif><img src="{{ asset($image) }}" alt=""></button>
        @endforeach
    </div>

    <div class="da-product-layout">
        <div class="da-product-content">
            <p class="da-pickup-notice">● {{ $product['pickup'] }}</p>
            <div class="da-product-features">
                @foreach ($product['features'] as [$icon, $title, $detail])
                    <span>{{ $icon }} <b>{{ $title }}</b><small>{{ $detail }}</small></span>
                @endforeach
            </div>

            <section class="da-product-section"><h2>About</h2><p>{{ $product['about'] }}</p><ul><li>Duration: {{ $product['duration'] }}</li><li>Language: English</li></ul></section>
            <details class="da-product-disclosure"><summary>Full description <b>⌄</b></summary><p>{{ $product['description'] }}</p></details>

            <section class="da-itinerary"><h2>Experience itinerary</h2><ol>@foreach ($product['itinerary'] as [$title, $description, $duration])<li><b>{{ $title }}</b><p>{{ $description }}</p><small>◷ {{ $duration }}</small></li>@endforeach</ol></section>
            <details class="da-product-disclosure"><summary>Highlights <b>⌄</b></summary><p>This is a static experience preview. Highlight details shown here are illustrative and should be confirmed before any future booking.</p></details>
            <details class="da-product-disclosure"><summary>Know before you go <b>⌄</b></summary><p>{{ $product['know_before'] }}</p></details>
            <details class="da-product-disclosure"><summary>Age policy <b>⌄</b></summary><p>{{ $product['age_policy'] }}</p></details>
            <details class="da-product-disclosure"><summary>Cancellation policy <b>⌄</b></summary><p>{{ $product['cancellation'] }}</p></details>

            <div class="da-video-preview"><img src="{{ asset($product['video_image']) }}" alt="{{ $product['title'] }} video preview" loading="lazy"><button type="button" aria-label="Preview {{ $product['title'] }} video" data-video-preview>▶</button><strong>{{ $product['title'] }} preview</strong><span data-video-status aria-live="polite"></span></div>
        </div>

        <aside class="da-booking-card" data-booking-card>
            <p>Sample from <strong data-booking-total>AED {{ number_format($product['booking']['base_price']) }}</strong><small>Example price only — not live</small></p>
            <h2>Select date and travellers</h2>
            <label>Date<input type="date" data-booking-date></label>
            <div class="da-traveller-grid">
                <div><span>Adults</span><div class="da-quantity-control"><button type="button" data-quantity-action="decrease" data-quantity="adults" aria-label="Decrease adults">−</button><output data-quantity-output="adults">1</output><button type="button" data-quantity-action="increase" data-quantity="adults" aria-label="Increase adults">+</button></div></div>
                <div><span>Children</span><div class="da-quantity-control"><button type="button" data-quantity-action="decrease" data-quantity="children" aria-label="Decrease children">−</button><output data-quantity-output="children">0</output><button type="button" data-quantity-action="increase" data-quantity="children" aria-label="Increase children">+</button></div></div>
            </div>
            <label>Choose your sample service<select data-booking-service>@foreach ($product['booking']['services'] as $service)<option value="{{ $service['price'] }}">{{ $service['label'] }} — AED {{ number_format($service['price']) }}</option>@endforeach</select></label>
            <small>Sample availability and prices only. This interface does not create a booking or payment.</small>
            <button type="button" class="da-check-availability" data-check-availability>Check sample availability <span aria-hidden="true">→</span></button>
            <p class="da-booking-status" data-booking-status aria-live="polite"></p>
        </aside>
    </div>

    <x-desert-adventures.related-experiences :products="$relatedProducts" />
    <x-desert-adventures.recently-viewed :products="$products" :current-product-key="$product['route']" />
</section>
