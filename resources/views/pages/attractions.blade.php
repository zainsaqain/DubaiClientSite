@extends('layouts.desert-adventures')

@section('title', 'Dubai Attractions | Waheed Murad Tourism')

@section('content')
    <section class="sports-events-page attractions-page da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Attractions']]" />

        <div class="sports-events-heading attractions-heading">
            <div><span class="sports-events-eyebrow">ICONIC DUBAI</span><h1>Dubai <span>Attractions</span></h1><p>Discover Dubai’s unforgettable landmarks, thrilling views and family-friendly experiences — all in one easy place.</p></div>
            <a href="{{ url('/') }}#booking" class="sports-events-plan">Plan your day <span aria-hidden="true">→</span></a>
        </div>

        <div class="attractions-highlights" aria-label="Attractions highlights"><span><b>✦</b>Iconic landmarks</span><span><b>⌖</b>Dubai experiences</span><span><b>◷</b>Instant booking</span><span><b>♥</b>Family favourites</span></div>

        <div class="sports-events-layout">
            <aside class="sports-events-filter" aria-label="Attraction filters">
                <div class="sports-filter-heading"><strong>Find your experience</strong><span>{{ count($attractions) }} attractions</span></div>
                <details open><summary>Category <b>⌃</b></summary><label><input type="checkbox" checked> Attractions</label><label><input type="checkbox"> Entry tickets</label><label><input type="checkbox"> City passes</label></details>
                <details open><summary>Location <b>⌃</b></summary><label><input type="checkbox"> Dubai</label><label><input type="checkbox"> Palm Jumeirah</label></details>
                <details open><summary>Experience type <b>⌃</b></summary><label><input type="checkbox"> Family experiences</label><label><input type="checkbox"> Sky views</label><label><input type="checkbox"> Culture &amp; landmarks</label></details>
                <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>Not sure where to start?<br><a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Ask our local team</a></p></div>
            </aside>

            <div class="sports-events-results">
                <div class="sports-results-bar"><strong><span>{{ count($attractions) }}</span> attractions to explore</strong><label>Sort by <select><option>Most popular</option><option>Price: Low to high</option><option>Price: High to low</option></select></label></div>
                <div class="sports-event-list">
                    @forelse ($attractions as $attraction)
                        <article class="sports-event-card attraction-card">
                            <img src="{{ asset($attraction['image']) }}" alt="{{ $attraction['title'] }}" loading="lazy">
                            <div class="sports-event-copy"><span>{{ $attraction['tag'] }}</span><h2>{{ $attraction['title'] }}</h2><p>{{ $attraction['description'] }}</p><small>⌖ {{ $attraction['location'] }}</small></div>
                            <div class="sports-event-action"><small>From</small><strong>{{ $attraction['price'] }}</strong><a href="{{ $attraction['url'] ?? url('/') }}#booking">Book now <span aria-hidden="true">→</span></a></div>
                        </article>
                    @empty
                        <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>There are no live attractions yet. Please check back soon.</p></div>
                    @endforelse
                </div>
                <p class="sports-events-note">You’ve explored all {{ count($attractions) }} attractions.</p>
            </div>
        </div>

        <section class="attractions-callout"><div><span>MAKE IT A DAY TO REMEMBER</span><h2>Dubai’s biggest moments are waiting for you.</h2><p>From the first view to the final photograph, our team makes planning your perfect Dubai day easy.</p></div><a href="{{ url('/') }}#booking">Explore all experiences <span aria-hidden="true">→</span></a></section>
    </section>
@endsection
