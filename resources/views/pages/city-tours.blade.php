@extends('layouts.desert-adventures')

@section('title', 'Dubai City Tours | Waheed Murad Tourism')

@section('content')
    <section class="sports-events-page city-tours-page da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'City Tours']]" />

        <div class="sports-events-heading city-tours-heading"><div><span class="sports-events-eyebrow">DISCOVER THE UAE</span><h1>Dubai <span>City Tours</span></h1><p>Discover stories, culture and extraordinary views with thoughtfully planned city tours across Dubai and the UAE.</p></div><a href="{{ url('/') }}#booking" class="sports-events-plan">Plan your city day <span aria-hidden="true">→</span></a></div>

        <div class="city-tours-highlights" aria-label="City tour highlights"><span><b>⌖</b>Dubai &amp; Abu Dhabi</span><span><b>✦</b>Expert local guides</span><span><b>◷</b>Flexible itineraries</span><span><b>♥</b>Private options</span></div>

        <div class="sports-events-layout">
            <aside class="sports-events-filter" aria-label="City tour filters">
                <div class="sports-filter-heading"><strong>Find your city tour</strong><span>{{ count($tours) }} experiences</span></div>
                <details open><summary>Category <b>⌃</b></summary><label><input type="checkbox" checked> City tours</label><label><input type="checkbox"> Private tours</label></details>
                <details open><summary>Destination <b>⌃</b></summary><label><input type="checkbox"> Dubai</label><label><input type="checkbox"> Abu Dhabi</label><label><input type="checkbox"> Sharjah &amp; Al Ain</label></details>
                <details open><summary>Tour style <b>⌃</b></summary><label><input type="checkbox"> Full day</label><label><input type="checkbox"> Heritage &amp; culture</label><label><input type="checkbox"> Private guide</label></details>
                <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>Need help choosing?<br><a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Ask our local team</a></p></div>
            </aside>

            <div class="sports-events-results">
                <div class="sports-results-bar"><strong><span>{{ count($tours) }}</span> city tours to explore</strong><label>Sort by <select><option>Most popular</option><option>Price: Low to high</option><option>Price: High to low</option></select></label></div>
                <div class="sports-event-list">
                    @forelse ($tours as $tour)
                        <article class="sports-event-card city-tour-card"><img src="{{ asset($tour['image']) }}" alt="{{ $tour['title'] }}" loading="lazy"><div class="sports-event-copy"><span>{{ $tour['tag'] }}</span><h2>{{ $tour['title'] }}</h2><p>{{ $tour['description'] }}</p><small>⌖ {{ $tour['location'] }}</small></div><div class="sports-event-action"><small>From</small><strong>{{ $tour['price'] }}</strong><a href="{{ $tour['url'] ?? url('/') }}#booking">Book now <span aria-hidden="true">→</span></a></div></article>
                    @empty
                        <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>There are no live city tours yet. Please check back soon.</p></div>
                    @endforelse
                </div>
                <p class="sports-events-note">You’ve explored all {{ count($tours) }} city tours.</p>
            </div>
        </div>

        <section class="city-tours-callout"><div><span>YOUR UAE, YOUR WAY</span><h2>Every city has a story worth discovering.</h2><p>Choose a relaxed private journey or a complete full-day experience, with local experts who bring every destination to life.</p></div><a href="{{ url('/') }}#booking">Start planning <span aria-hidden="true">→</span></a></section>
    </section>
@endsection
