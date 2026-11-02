@extends('layouts.desert-adventures')

@section('title', ($subcategory->meta_title ?: $subcategory->name.' City Tours').' | Waheed Murad Tourism')

@section('content')
    @php
        $destinationName = $subcategory->name;
        $destinationTitle = $destinationName.' City Tours';
        $destinationDescription = $subcategory->description ?: 'Explore '.$destinationName.' with thoughtfully planned city tours, local experiences and flexible itinerary options.';
    @endphp
    <main class="da-abu-dhabi-page">
        <section class="da-container da-abu-dhabi-hero">
            <h1>{{ $destinationTitle }}</h1>
            <p>{{ $destinationDescription }}</p>

            <div class="da-feature-list" aria-label="{{ $destinationName }} city tour highlights">
                <article>
                    <span aria-hidden="true">⌖</span>
                    <div><b>Transfers from Hotels</b><small>Shared or Private</small></div>
                </article>
                <article>
                    <span aria-hidden="true">✦</span>
                    <div><b>Expert Guides</b><small>Multi-lingual</small></div>
                </article>
                <article>
                    <span aria-hidden="true">✓</span>
                    <div><b>Admission Tickets</b><small>Entry fees when included</small></div>
                </article>
                <article>
                    <span aria-hidden="true">☕</span>
                    <div><b>Food Stops</b><small>Scheduled refreshment breaks</small></div>
                </article>
            </div>
        </section>

        <section class="da-container da-abu-tour-collection" aria-labelledby="destination-tours-title">
            <div class="da-abu-section-heading">
                <h2 id="destination-tours-title">Explore the {{ $destinationTitle }} available</h2>
                <div class="da-abu-slider-controls" aria-label="Tour cards"><button type="button" aria-label="Previous tours">‹</button><button type="button" aria-label="Next tours">›</button></div>
            </div>

            @if ($tours->isNotEmpty())
                <div class="da-abu-tour-grid">
                    @foreach ($tours as $tour)
                        <x-desert-adventures.product-preview-card :product="$tour" data-tour-card-id="{{ $tour->id }}" />
                    @endforeach
                </div>
            @else
                <div class="da-abu-tour-grid da-abu-tour-grid--preview" aria-label="{{ $destinationName }} tour previews">
                    <article class="da-abu-tour-card">
                        <img src="{{ asset('images/abu-dhabi/abu-dhabi-corniche.png') }}" alt="{{ $destinationName }} city skyline" loading="lazy">
                        <div><small>City Tours</small><h3>Private {{ $destinationName }} City Tour</h3><p>A tailored day to discover local culture, architecture and waterfront views.</p><strong>Price on request</strong><a href="{{ route('city-tours') }}">Explore tours</a></div>
                    </article>
                    <article class="da-abu-tour-card">
                        <img src="{{ asset('images/abu-dhabi/abu-dhabi-mosque.png') }}" alt="{{ $destinationName }} heritage architecture" loading="lazy">
                        <div><small>City Tours</small><h3>{{ $destinationName }} Heritage Tour</h3><p>Explore landmark architecture and cultural spaces at a relaxed pace.</p><strong>Price on request</strong><a href="{{ route('city-tours') }}">Explore tours</a></div>
                    </article>
                    <article class="da-abu-tour-card">
                        <img src="{{ asset('images/abu-dhabi/abu-dhabi-attractions.png') }}" alt="{{ $destinationName }} family attraction" loading="lazy">
                        <div><small>City Tours</small><h3>{{ $destinationName }} Attractions Tour</h3><p>Enjoy a city day built around memorable family experiences.</p><strong>Price on request</strong><a href="{{ route('city-tours') }}">Explore tours</a></div>
                    </article>
                </div>
            @endif
        </section>

        <section class="da-container da-abu-story" aria-labelledby="destination-story-title">
            <div class="da-abu-story-heading">
                <h2 id="destination-story-title">{{ $destinationTitle }} with <em>Waheed Murad Tourism</em></h2>
            </div>

            <article class="da-abu-story-panel">
                <img class="da-abu-story-image" src="{{ asset('images/abu-dhabi/abu-dhabi-mosque.png') }}" alt="{{ $destinationName }} heritage architecture" loading="lazy">
                <div>
                    <h3>Fascinating experiences</h3>
                    <p>Build a city day around places that reveal {{ $destinationName }}'s history, hospitality and distinctive character. Each tour can be tailored in the catalogue with its own itinerary, inclusions and timing.</p>
                </div>
            </article>
            <article class="da-abu-story-panel da-abu-story-panel--reverse">
                <img class="da-abu-story-image" src="{{ asset('images/abu-dhabi/abu-dhabi-corniche.png') }}" alt="{{ $destinationName }} coastal cityscape" loading="lazy">
                <div>
                    <h3>Iconic landmarks</h3>
                    <p>From landmark views to cultural spaces, {{ $destinationName }} offers a thoughtful mix of discovery and memorable moments. Each product card is populated from the City Tours catalogue.</p>
                </div>
            </article>
            <article class="da-abu-story-panel">
                <img class="da-abu-story-image" src="{{ asset('images/abu-dhabi/abu-dhabi-museum.png') }}" alt="{{ $destinationName }} cultural attraction" loading="lazy">
                <div>
                    <h3>World-class attractions</h3>
                    <p>Use this page as the City Tours → {{ $destinationName }} destination hub. Each live tour is linked to its own detail page, pricing, gallery and availability information.</p>
                </div>
            </article>
        </section>

        <section class="da-container da-abu-faq" aria-labelledby="destination-faq-title">
            <h2 id="destination-faq-title">{{ $destinationTitle }}: Frequently asked <span>questions</span></h2>
            <details><summary>Is a {{ $destinationName }} day trip right for me? <b>+</b></summary><p>Choose the itinerary that fits your interests and check the individual tour page for its available duration and inclusions.</p></details>
            <details><summary>How long is a {{ $destinationName }} tour? <b>+</b></summary><p>Duration is set individually for each tour and is displayed on its tour detail page.</p></details>
            <details><summary>What is included in a {{ $destinationName }} tour? <b>+</b></summary><p>Included services vary by product. Please review the selected tour’s itinerary and package information before booking.</p></details>
        </section>
    </main>
@endsection
