@extends('layouts.desert-adventures')

@section('title', 'Dubai Attractions | Waheed Murad Tourism')

@section('content')
    @php
        $attractions = [
            ['title' => 'Dubai Aquarium & Underwater Zoo', 'image' => 'images/hero-dubai-aquarium.png', 'tag' => 'Top attraction', 'description' => 'Step into a spectacular underwater world filled with sharks, rays and more than 33,000 aquatic animals.', 'price' => 'PKR 8,950'],
            ['title' => 'Global Village Entry Ticket', 'image' => 'images/global-village-dubai.png', 'tag' => 'Family favourite', 'description' => 'Discover pavilions, entertainment, street food and colourful moments from around the world.', 'price' => 'PKR 2,308'],
            ['title' => 'Helicopter Tour in Dubai', 'image' => 'images/helicopter-tour-dubai.png', 'tag' => 'Skyline views', 'description' => 'See Palm Jumeirah, Burj Khalifa and Dubai’s iconic coastline from an unforgettable new perspective.', 'price' => 'PKR 54,631'],
            ['title' => 'At The Top, Burj Khalifa', 'image' => 'images/dubai-adventure.png', 'tag' => 'Entry ticket', 'description' => 'Travel high above the city for extraordinary views from the world’s most celebrated tower.', 'price' => 'PKR 14,563'],
            ['title' => 'The View at The Palm', 'image' => 'images/cruise-dubai-marina.png', 'tag' => 'Observation deck', 'description' => 'Take in the breathtaking panorama of Palm Jumeirah, Dubai Marina and the Arabian Gulf.', 'price' => 'PKR 14,236'],
            ['title' => 'Dubai Frame Entrance Ticket', 'image' => 'images/dubai-attractions.png', 'tag' => 'City landmark', 'description' => 'Walk between old and new Dubai at one of the city’s most distinctive architectural landmarks.', 'price' => 'PKR 8,440'],
        ];
    @endphp

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
                    @foreach ($attractions as $attraction)
                        <article class="sports-event-card attraction-card">
                            <img src="{{ asset($attraction['image']) }}" alt="{{ $attraction['title'] }}" loading="lazy">
                            <div class="sports-event-copy"><span>{{ $attraction['tag'] }}</span><h2>{{ $attraction['title'] }}</h2><p>{{ $attraction['description'] }}</p><small>⌖ Dubai</small></div>
                            <div class="sports-event-action"><small>From</small><strong>{{ $attraction['price'] }}</strong><a href="{{ url('/') }}#booking">Book now <span aria-hidden="true">→</span></a></div>
                        </article>
                    @endforeach
                </div>
                <p class="sports-events-note">You’ve explored all {{ count($attractions) }} attractions.</p>
            </div>
        </div>

        <section class="attractions-callout"><div><span>MAKE IT A DAY TO REMEMBER</span><h2>Dubai’s biggest moments are waiting for you.</h2><p>From the first view to the final photograph, our team makes planning your perfect Dubai day easy.</p></div><a href="{{ url('/') }}#booking">Explore all experiences <span aria-hidden="true">→</span></a></section>
    </section>
@endsection
