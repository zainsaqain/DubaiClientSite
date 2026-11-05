@extends('layouts.desert-adventures')

@section('title', ($tour->meta_title ?: $tour->name).' | Waheed Murad Tourism')

@section('meta_description', $tour->meta_description ?: $tour->short_description)

@section('content')
@php
    $gallery = $tour->images->pluck('path')->prepend($tour->main_image ?: $tour->thumbnail)->filter()->unique()->values();
    $mainImage = $gallery->first() ?: $tour->thumbnail;
    $sideImages = $gallery->skip(1)->take(2);
    $visibleFeatures = $tour->features->where('is_active', true);
    $youtubeThumbnail = $tour->youtubeThumbnailUrl();
    $isWishlisted = auth()->check() && ! auth()->user()->is_admin
        ? auth()->user()->wishlists()->where('tour_id', $tour->id)->exists()
        : false;
    $activePackages = $tour->packages->where('is_active', true);
    $activePrices = $tour->prices->where('is_active', true);
    $bookingPrices = $activePrices->values();
    $defaultBookingPrice = $bookingPrices->first();
    $bookingCurrency = $defaultBookingPrice?->currency ?: $tour->currency;
    $isDesertAdventure = $tour->category?->slug === 'desert-adventures';
    $isCityTour = $tour->category?->slug === 'city-tours';
    $categoryUrl = $tour->category
        ? ($isDesertAdventure ? route('desert-adventures') : ($isCityTour ? route('city-tours') : route('tour-categories.show', $tour->category)))
        : route('tours.search');
    $subcategoryUrl = $tour->category && $tour->subcategory
        ? ($isDesertAdventure ? url('/desert-adventures/'.$tour->subcategory->slug) : ($isCityTour ? route('city-tours.destination', $tour->subcategory) : route('tour-subcategories.show', [$tour->category, $tour->subcategory])))
        : null;
@endphp

<section class="da-product-page da-container">
    <x-breadcrumb :items="array_filter([['label' => 'Home', 'url' => route('home')], ['label' => $tour->category?->name ?? 'Tours', 'url' => $categoryUrl], $tour->subcategory ? ['label' => $tour->subcategory->name, 'url' => $subcategoryUrl] : null, ['label' => $tour->name]])" />

    <div class="da-product-heading">
        <div>
            <span>{{ $tour->subcategory?->name ?? $tour->category?->name }} · {{ $tour->location }}</span>
            <h1>{{ $tour->name }}</h1>
            <p>By WaheDed Murad Tourism</p>
        </div>
        <div class="da-product-awards" aria-label="Experience badges">
            @if($tour->is_bestseller)<span>Bestseller</span>@endif
            @if($tour->is_travellers_choice)<span>2025 Travellers' Choice</span>@endif
            @if($tour->location_badge)<span>⌖ {{ $tour->location_badge }}</span>@endif
        </div>
        <div class="da-product-actions">
            @auth
                @if (! auth()->user()->is_admin)
                    @if ($isWishlisted)
                        <form method="POST" action="{{ route('tours.wishlist.destroy', $tour) }}">@csrf @method('DELETE')<button class="is-saved" type="submit" aria-label="Remove {{ $tour->name }} from wishlist">♥ <span>Saved</span></button></form>
                    @else
                        <form method="POST" action="{{ route('tours.wishlist.store', $tour) }}">@csrf <button type="submit" aria-label="Add {{ $tour->name }} to wishlist">♡ <span>Wishlist</span></button></form>
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" aria-label="Log in to add {{ $tour->name }} to wishlist">♡ <span>Wishlist</span></a>
            @endauth
            <button type="button" data-share-tour data-share-title="{{ $tour->name }}" data-share-url="{{ route('tours.show', $tour) }}" aria-label="Share {{ $tour->name }}">↗ <span>Share</span></button>
            <span class="da-product-share-status" data-share-status aria-live="polite"></span>
        </div>
    </div>

    <div class="da-product-gallery" aria-label="{{ $tour->name }} gallery">
        <figure class="da-product-gallery-main">
            <img src="{{ $tour->imageUrl($mainImage) }}" alt="{{ $tour->image_alt ?: $tour->name }}" fetchpriority="high">
            @if($tour->is_original)<figcaption>Original</figcaption>@endif
        </figure>
        <div class="da-product-gallery-side">
            @forelse($sideImages as $image)
                <img src="{{ $tour->imageUrl($image) }}" alt="{{ $tour->image_alt ?: $tour->name }}" loading="lazy">
            @empty
                <img src="{{ $tour->imageUrl($mainImage) }}" alt="{{ $tour->image_alt ?: $tour->name }}" loading="lazy">
                <img src="{{ $tour->imageUrl($mainImage) }}" alt="{{ $tour->image_alt ?: $tour->name }}" loading="lazy">
            @endforelse
            <button class="da-product-gallery-count" type="button" data-gallery-open>See all photos</button>
        </div>
    </div>
    <div class="da-gallery-modal" data-gallery-modal hidden aria-hidden="true">
        <button class="da-gallery-modal-scrim" type="button" data-gallery-close aria-label="Close photo gallery"></button>
        <section class="da-gallery-modal-dialog" role="dialog" aria-modal="true" aria-label="{{ $tour->name }} photo gallery">
            <header><h2>{{ $tour->name }} photos</h2><button type="button" data-gallery-close aria-label="Close photo gallery">×</button></header>
            <div class="da-gallery-modal-grid">
                @foreach($gallery as $image)
                    <img src="{{ $tour->imageUrl($image) }}" alt="{{ $tour->image_alt ?: $tour->name }}" loading="lazy">
                @endforeach
            </div>
        </section>
    </div>

    <div class="da-pickup-callout-row">
        <div class="da-pickup-callout"><span class="da-callout-icon">◉</span><span>{{ $tour->pickup_information ?: 'Hotel or residence pick-up is available from '.$tour->location.'.' }}</span></div>
        <div class="da-callout-price"><div class="da-callout-price-val">From <strong>{{ $tour->currency }} {{ number_format((float) $tour->starting_price) }}</strong></div><small>Price varies by vehicle, group sizes and other selections</small></div>
    </div>

    <div class="da-product-layout">
        <div class="da-product-content">
            @if($visibleFeatures->isNotEmpty())
                <div class="da-features-grid-12">
                    @foreach($visibleFeatures as $feature)
                        <div class="da-feature-item"><span class="da-feature-orb"><x-tour-feature-icon :name="$feature->displayIcon()" /></span><span class="da-feature-label">{{ $feature->name }}@if($feature->pivot->inclusion_status === 'optional') <small>optional</small>@endif</span></div>
                    @endforeach
                </div>
            @endif

            <section class="da-product-section">
                <h2>About</h2>
                <p>{{ $tour->about ?: $tour->short_description }}</p>
                <div class="da-duration-info"><span>◷</span><span>Duration: {{ $tour->duration ? $tour->duration.' '.$tour->duration_unit : 'Flexible' }}</span></div>
                <div class="da-duration-info"><span>◉</span><span>Language: {{ implode(', ', $tour->languages ?? []) }}</span></div>
            </section>

            @if($tour->full_description)<details class="da-product-disclosure"><summary>Full description <b>⌄</b></summary><p>{!! nl2br(e($tour->full_description)) !!}</p></details>@endif
            @if($tour->itineraries->isNotEmpty())<section class="da-itinerary"><h2>Experience itinerary</h2><ol>@foreach($tour->itineraries as $step)<li><b>{{ $step->title }}</b><p>{{ $step->description }}</p><small>◷ {{ $step->duration ? $step->duration.' '.$step->duration_unit : 'At your own pace' }}</small></li>@endforeach</ol></section>@endif
            @foreach (['Highlights' => 'highlights', 'Know before you go' => 'know_before_you_go', 'Age policy' => 'age_policy', 'Cancellation policy' => 'cancellation_policy', 'Additional notes' => 'additional_notes'] as $label => $field)
                @if ($tour->$field)<details class="da-product-disclosure"><summary>{{ $label }} <b>⌄</b></summary><p>{!! nl2br(e($tour->$field)) !!}</p></details>@endif
            @endforeach
            @if($tour->youtube_url)<a class="da-video-preview" href="{{ $tour->youtube_url }}" target="_blank" rel="noopener" aria-label="Watch {{ $tour->name }} on YouTube"><img src="{{ $youtubeThumbnail ?: $tour->imageUrl($mainImage) }}" alt="{{ $tour->name }} video preview" loading="lazy" data-video-thumbnail data-fallback="{{ $tour->imageUrl($mainImage) }}"><span class="da-video-preview-play" aria-hidden="true">▶</span><strong>Watch {{ $tour->name }} video</strong><span class="da-video-preview-source">Watch on YouTube</span></a>@endif
        </div>

        <form method="POST" action="{{ route('cart.store', $tour) }}" class="da-booking-card" data-booking-card data-currency="{{ $bookingCurrency }}">
            @csrf
            <h2>Select Date and Travelers</h2>
            <div class="da-booking-input-wrap"><span>▣</span><input name="travel_date" data-booking-date type="date" min="{{ now()->toDateString() }}" aria-label="Select date" required></div>
            <input type="hidden" name="adults" value="1" data-cart-quantity="adults">
            <input type="hidden" name="children" value="0" data-cart-quantity="children">
            <input type="hidden" name="infants" value="0" data-cart-quantity="infants">
            <button type="button" class="da-booking-input-wrap da-traveler-toggle" data-traveler-toggle aria-expanded="false">
                <span>♧</span><strong data-traveler-summary>1 adult</strong>
            </button>
            <div class="da-traveler-picker" data-traveler-picker hidden>
                @foreach ([['adults', 'Adults', 1], ['children', 'Children', 0], ['infants', 'Infants', 0]] as [$key, $label, $minimum])
                    <div class="da-traveler-row">
                        <span><strong>{{ $label }}</strong><small>{{ $key === 'children' ? 'Ages 5 to 11' : ($key === 'infants' ? 'Below 5 years' : 'Age 12+') }}</small></span>
                        <div>
                            <button type="button" data-quantity="{{ $key }}" data-quantity-action="decrease" aria-label="Remove {{ Str::lower($label) }}">−</button>
                            <output data-quantity-output="{{ $key }}">{{ $minimum }}</output>
                            <button type="button" data-quantity="{{ $key }}" data-quantity-action="increase" aria-label="Add {{ Str::lower($label) }}">+</button>
                        </div>
                    </div>
                @endforeach
                <button type="button" class="da-traveler-confirm" data-traveler-confirm>Confirm</button>
            </div>

            @if ($bookingPrices->isNotEmpty())
                <details class="da-booking-options" open>
                    <summary>Choose Your Vehicle <b>⌄</b></summary>
                    @foreach ($bookingPrices as $price)
                        @php
                            $priceLabel = $price->vehicle_label ?: ($price->package?->name ?: ucfirst($price->vehicle_type ?: 'Tour option'));
                            $priceDescription = $price->description ?: $price->package?->description;
                        @endphp
                        <label class="da-booking-option">
                            <input type="radio" name="tour_price_id" value="{{ $price->id }}" data-booking-service-choice data-adult-price="{{ $price->adult_price }}" data-child-price="{{ $price->child_price ?? 0 }}" data-infant-price="{{ $price->infant_price ?? 0 }}" @checked($loop->first)>
                            <span><strong>{{ $priceLabel }}</strong>@if ($priceDescription)<small>{{ $priceDescription }}</small>@endif</span>
                            <b>{{ $price->currency }} {{ number_format((float) $price->adult_price) }}</b>
                        </label>
                    @endforeach
                </details>
                <select data-booking-service hidden aria-hidden="true">
                    @foreach ($bookingPrices as $price)<option value="{{ $price->adult_price }}" data-child-price="{{ $price->child_price ?? 0 }}" data-infant-price="{{ $price->infant_price ?? 0 }}" @selected($loop->first)>{{ $price->id }}</option>@endforeach
                </select>
            @else
                <p class="da-booking-empty">Pricing will be confirmed by our travel team.</p>
            @endif
            <p class="da-booking-total">Estimated total: <strong data-booking-total>{{ $bookingCurrency }} {{ number_format((float) ($defaultBookingPrice?->adult_price ?? $tour->starting_price)) }}</strong></p>
            <button type="submit" class="da-check-avail-btn da-add-to-cart-btn">Add to cart <span aria-hidden="true">→</span></button>
            <a class="da-bank-transfer-btn" href="{{ route('checkout.create', $tour) }}">Book with bank transfer <span aria-hidden="true">→</span></a>
            <p class="da-booking-status">Choose your date and travellers, then continue to your cart.</p>
        </form>
    </div>

    <x-desert-adventures.related-experiences :products="$relatedTours" />
    <x-desert-adventures.recently-viewed :products="$recentTours" :current-product-key="$tour->slug" />
</section>
@endsection
