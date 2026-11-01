@extends('layouts.desert-adventures')

@section('title', ($tour->meta_title ?: $tour->name).' | Waheed Murad Tourism')

@section('meta_description', $tour->meta_description ?: $tour->short_description)

@section('content')
@php
    $gallery = $tour->images->pluck('path')->prepend($tour->main_image ?: $tour->thumbnail)->filter()->unique()->values();
    $mainImage = $gallery->first() ?: $tour->thumbnail;
    $sideImages = $gallery->skip(1)->take(2);
    $visibleFeatures = $tour->features->where('is_active', true);
    $activePackages = $tour->packages->where('is_active', true);
    $activePrices = $tour->prices->where('is_active', true);
    $categoryUrl = $tour->category ? route('tour-categories.show', $tour->category) : route('tours.search');
    $subcategoryUrl = $tour->category && $tour->subcategory ? route('tour-subcategories.show', [$tour->category, $tour->subcategory]) : null;
@endphp

<section class="da-product-page da-container">
    <x-breadcrumb :items="array_filter([['label' => 'Home', 'url' => route('home')], ['label' => $tour->category?->name ?? 'Tours', 'url' => $categoryUrl], $tour->subcategory ? ['label' => $tour->subcategory->name, 'url' => $subcategoryUrl] : null, ['label' => $tour->name]])" />

    <div class="da-product-heading">
        <div>
            <span>{{ $tour->subcategory?->name ?? $tour->category?->name }} · {{ $tour->location }}</span>
            <h1>{{ $tour->name }}</h1>
            <p>By Waheed Murad Tourism</p>
        </div>
        <div class="da-product-awards" aria-label="Experience badges">
            @if($tour->is_bestseller)<span>Bestseller</span>@endif
            @if($tour->is_travellers_choice)<span>2025 Travellers' Choice</span>@endif
            @if($tour->location_badge)<span>⌖ {{ $tour->location_badge }}</span>@endif
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
            <span class="da-product-gallery-count">See all photos</span>
        </div>
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
                        <div class="da-feature-item"><span class="da-feature-orb"><x-tour-feature-icon :name="$feature->icon" /></span><span class="da-feature-label">{{ $feature->name }}@if($feature->pivot->inclusion_status === 'optional') <small>optional</small>@endif</span></div>
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
            @if($tour->youtube_url)<a class="da-video-preview" href="{{ $tour->youtube_url }}" target="_blank" rel="noopener"><img src="{{ $tour->imageUrl($tour->main_image) }}" alt="{{ $tour->name }} video preview"><span>▶</span><strong>Watch {{ $tour->name }} video</strong></a>@endif
        </div>

        <aside class="da-booking-card">
            <h2>Select Date and Travelers</h2>
            <div class="da-booking-input-wrap"><span>▣</span><input type="date" min="{{ now()->toDateString() }}" aria-label="Select date"></div>
            <div class="da-booking-input-wrap"><span>♧</span><input type="number" min="1" value="1" aria-label="Number of guests"></div>
            <div class="da-booking-accordion-row"><span>Choose Your Vehicle</span><b>⌄</b></div>
            @forelse ($activePackages as $package)
                <div class="da-booking-accordion-row da-package-summary"><span><strong>{{ $package->name }}</strong>@if ($package->description)<small>{{ $package->description }}</small>@endif</span><b>{{ $package->prices->where('is_active', true)->min('adult_price') !== null ? $package->prices->where('is_active', true)->first()->currency.' '.number_format((float) $package->prices->where('is_active', true)->min('adult_price')) : '' }}</b></div>
            @empty
                @foreach ($activePrices->whereNull('tour_package_id') as $price)
                    <div class="da-booking-accordion-row da-package-summary"><span><strong>{{ ucfirst($price->vehicle_type) }}</strong><small>{{ $price->minimum_guests }} {{ Str::plural('guest', $price->minimum_guests) }} minimum</small></span><b>{{ $price->currency }} {{ number_format((float) $price->adult_price) }}</b></div>
                @endforeach
            @endforelse
            <button type="button" class="da-check-avail-btn">Check Availability</button>
        </aside>
    </div>
</section>
@endsection
