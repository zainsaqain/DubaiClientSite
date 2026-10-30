@props(['product'])

@php
    $products = config('adventure-products');
    $relatedProducts = collect($product['related'] ?? [])
        ->map(static fn (string $key) => $products[$key] ?? null)
        ->filter();

    $gallery = $product['gallery'] ?? ['images/safaris/evening-desert-safari.jpg', 'images/safaris/wide-view-of-desert-camp.jpg', 'images/safaris/camel-ride-safari.jpg', 'images/safaris/family-sandboarding.jpg'];
    $galleryAlt = $product['gallery_alt'] ?? [];

    $featuresList = [
        ['icon' => 'transfer', 'name' => 'Shared or Private Transfer'],
        ['icon' => 'dune', 'name' => 'Dune Drive'],
        ['icon' => 'tent', 'name' => 'DDCR Visitor Centre'],
        ['icon' => 'sun', 'name' => 'Sunset Stop'],
        ['icon' => 'falcon', 'name' => 'Falcon Show'],
        ['icon' => 'wildlife', 'name' => 'Wildlife'],
        ['icon' => 'camel', 'name' => 'Camel Ride'],
        ['icon' => 'sandboard', 'name' => 'Sandboarding optional'],
        ['icon' => 'walk', 'name' => 'Guided Nature Walk'],
        ['icon' => 'stars', 'name' => 'Stargazing'],
        ['icon' => 'bbq', 'name' => 'BBQ Buffet'],
        ['icon' => 'drinks', 'name' => 'Soft Drinks or House Beverages'],
    ];

    $mainImage = $product['gallery'][0];
    $mainAlt = $product['gallery_alt'][0] ?? $product['title'];
    $currency = $product['booking']['currency'] ?? 'AED';
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
        @if (count($product['badges'] ?? []))
            <div class="da-product-awards" aria-label="Experience badges">
                @foreach ($product['badges'] as $badge)<span>{{ $badge }}</span>@endforeach
            </div>
        @endif
    </div>

    {{-- Hero image carousel (No Original badge overlay) --}}
    <div class="da-hero-carousel" data-hero-carousel aria-label="{{ $product['title'] }} photos">
        <div class="da-hero-carousel-track">
            @foreach ($gallery as $i => $image)
                <div class="da-hero-slide {{ $i === 0 ? 'is-active' : '' }}" aria-hidden="{{ $i !== 0 ? 'true' : 'false' }}">
                    <img src="{{ asset($image) }}" alt="{{ $galleryAlt[$i] ?? $product['title'] }}" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                </div>
            @endforeach
        </div>
        <button class="da-hero-prev" type="button" data-hero-prev aria-label="Previous photo">&#8249;</button>
        <button class="da-hero-next" type="button" data-hero-next aria-label="Next photo">&#8250;</button>
        <button class="da-hero-see-all" type="button" data-hero-see-all>
            <svg viewBox="0 0 20 20" aria-hidden="true"><rect x="1" y="1" width="7" height="7" rx="1"/><rect x="12" y="1" width="7" height="7" rx="1"/><rect x="1" y="12" width="7" height="7" rx="1"/><rect x="12" y="12" width="7" height="7" rx="1"/></svg>
            See all photos
        </button>
        <div class="da-hero-dots" aria-hidden="true">
            @foreach ($gallery as $i => $image)
                <span class="da-hero-dot {{ $i === 0 ? 'is-active' : '' }}" data-hero-dot="{{ $i }}"></span>
            @endforeach
        </div>
    </div>

    {{-- Callout row: Pickup on left, Price on right --}}
    <div class="da-pickup-callout-row">
        <div class="da-pickup-callout">
            <span class="da-callout-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M11 5 6 9H2v6h4l5 4V5Z"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
            </span>
            <span>Hotel or residence pick-up included from anywhere in Dubai</span>
        </div>
        <div class="da-callout-price">
            <div class="da-callout-price-val">From <strong>PKR 49,937</strong></div>
            <small>Price varies by vehicle, group sizes and other selections</small>
        </div>
    </div>

    <div class="da-product-layout">
        <div class="da-product-content">
            {{-- 12 Circular Green Feature Icons matching Reference --}}
            <div class="da-features-grid-12">
                @foreach ($featuresList as $feat)
                    <div class="da-feature-item">
                        <span class="da-feature-orb">
                            @if ($feat['icon'] === 'transfer')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 17h14M4 11l2-4h12l2 4M6 14h.01M18 14h.01M3 11v6h18v-6"/></svg>
                            @elseif ($feat['icon'] === 'dune')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 18c4-4 8 2 12-2s6-2 8 0M3 12c3-3 6 1 10-2s5-1 8 1"/></svg>
                            @elseif ($feat['icon'] === 'tent')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m12 3 10 17H2L12 3Zm0 0v17M7 20l5-8 5 8"/></svg>
                            @elseif ($feat['icon'] === 'sun')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                            @elseif ($feat['icon'] === 'falcon')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 4s2 3 0 6c3 0 5 3 5 6-3 0-6-2-8-5 0 3-2 6-5 7 1-4 3-6 5-8-2 0-4-2-4-4 2 1 4 0 5-2 1 0 3-1 7 0Z"/></svg>
                            @elseif ($feat['icon'] === 'wildlife')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 3v5l3 3h6l3-3V3M9 8h6M8 11v6l4 4 4-4v-6"/></svg>
                            @elseif ($feat['icon'] === 'camel')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 18v-4c0-2 1-3 3-3 1 0 2 1 3 2 1-2 2-3 4-3s3 1 4 3v5M8 18v4M16 18v4M4 11V7l3-3h3v3"/></svg>
                            @elseif ($feat['icon'] === 'sandboard')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="5" r="2"/><path d="m15 11-3-2-3 2v4l3-1 3 1v-4ZM5 20c4-1 10-1 14 0"/></svg>
                            @elseif ($feat['icon'] === 'walk')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="13" cy="4" r="2"/><path d="m10 21 2-6 3 2v4M14 9l-3 4-3-2-2 4"/></svg>
                            @elseif ($feat['icon'] === 'stars')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3a9 9 0 1 0 9 9c0-.46-.04-.92-.1-1.36a5.389 5.389 0 0 1-4.4 2.26 5.403 5.403 0 0 1-3.14-9.8c.44-.06.9-.1 1.36-.1h-2.72Z"/><path d="M19 5v4M21 7h-4"/></svg>
                            @elseif ($feat['icon'] === 'bbq')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 10h16a8 8 0 0 1-16 0ZM7 10V4M12 10V4M17 10V4M6 18l-2 3M18 18l2 3M12 18v3"/></svg>
                            @elseif ($feat['icon'] === 'drinks')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 4h12l-2 15a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2L6 4ZM5 4h14M12 2v2"/></svg>
                            @endif
                        </span>
                        <span class="da-feature-label">{{ $feat['name'] }}</span>
                    </div>
                @endforeach
            </div>

            <section class="da-product-section">
                <h2>About</h2>
                <p>Our Evening Desert Safari features an unforgettable itinerary of activities, from breathtaking sunset stops and wildlife spotting to a sumptuous BBQ buffet and stargazing in a Bedouin-inspired camp.</p>
                <div class="da-duration-info">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    <span>Duration: 6 hours</span>
                </div>
            </section>

            <details class="da-product-disclosure"><summary>Full description <b>⌄</b></summary><p>{{ $product['description'] }}</p></details>

            <section class="da-itinerary"><h2>Experience itinerary</h2><ol>@foreach ($product['itinerary'] as [$title, $description, $duration])<li><b>{{ $title }}</b><p>{{ $description }}</p><small>◷ {{ $duration }}</small></li>@endforeach</ol></section>
            <details class="da-product-disclosure"><summary>Highlights <b>⌄</b></summary><p>This is a static experience preview. Highlight details shown here are illustrative and should be confirmed before any future booking.</p></details>
            <details class="da-product-disclosure"><summary>Know before you go <b>⌄</b></summary><p>{{ $product['know_before'] }}</p></details>
            <details class="da-product-disclosure"><summary>Age policy <b>⌄</b></summary><p>{{ $product['age_policy'] }}</p></details>
            <details class="da-product-disclosure"><summary>Cancellation policy <b>⌄</b></summary><p>{{ $product['cancellation'] }}</p></details>

            <div class="da-video-preview"><img src="{{ asset($product['video_image']) }}" alt="{{ $product['title'] }} video preview" loading="lazy"><button type="button" aria-label="Preview {{ $product['title'] }} video" data-video-preview>▶</button><strong>{{ $product['title'] }} preview</strong><span data-video-status aria-live="polite"></span></div>
        </div>

        <aside class="da-booking-card" data-booking-card>
            <h2>Select Date and Travelers</h2>
            <div class="da-booking-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <input type="text" placeholder="Date" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" data-booking-date>
            </div>
            <div class="da-booking-input-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M6 20v-1a6 6 0 0 1 12 0v1"/></svg>
                <input type="text" placeholder="Number of guests" value="2 Travelers" data-booking-guests>
            </div>

            <div class="da-booking-accordion-row">
                <span>Choose Your Vehicle</span>
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="m4 6 4 4 4-4"/></svg>
            </div>
            <div class="da-booking-accordion-row">
                <span>Choose Your Package</span>
                <svg viewBox="0 0 16 16" fill="currentColor"><path d="m4 6 4 4 4-4"/></svg>
            </div>

            <button type="button" class="da-check-avail-btn" data-check-availability>Check Availability</button>
        <aside class="da-booking-card" data-booking-card data-currency="{{ $currency }}">
            <p>From <strong data-booking-total>{{ $currency }} {{ number_format($product['booking']['base_price']) }}</strong><small>Per person · final availability confirmed at booking</small></p>
            <h2>Select date and travellers</h2>
            <label>Date<input type="date" data-booking-date></label>
            <div class="da-traveller-grid">
                <div><span>Adults</span><div class="da-quantity-control"><button type="button" data-quantity-action="decrease" data-quantity="adults" aria-label="Decrease adults">−</button><output data-quantity-output="adults">1</output><button type="button" data-quantity-action="increase" data-quantity="adults" aria-label="Increase adults">+</button></div></div>
                <div><span>Children</span><div class="da-quantity-control"><button type="button" data-quantity-action="decrease" data-quantity="children" aria-label="Decrease children">−</button><output data-quantity-output="children">0</output><button type="button" data-quantity-action="increase" data-quantity="children" aria-label="Increase children">+</button></div></div>
            </div>
            <label>Choose your package<select data-booking-service>@foreach ($product['booking']['services'] as $service)<option value="{{ $service['price'] }}">{{ $service['label'] }} — {{ $currency }} {{ number_format($service['price']) }}</option>@endforeach</select></label>
            <small>Select a date and travellers to review your preferred experience package.</small>
            <button type="button" class="da-check-availability" data-check-availability>Check availability <span aria-hidden="true">→</span></button>
            <p class="da-booking-status" data-booking-status aria-live="polite"></p>
        </aside>
    </div>

    {{-- Chat with us floating widget --}}
    <a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer" class="da-chat-float" aria-label="Chat with us on WhatsApp">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 11.7a8.4 8.4 0 0 1-12.4 7.4L3.5 20.5l1.5-4.3A8.4 8.4 0 1 1 20.5 11.7Z"/></svg>
        <span>Chat with us</span>
    </a>

    <x-desert-adventures.related-experiences :products="$relatedProducts" />
    <x-desert-adventures.recently-viewed :products="$products" :current-product-key="$product['route']" />
</section>
