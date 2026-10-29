@extends('layouts.desert-adventures')

@section('title', 'Cruise and Boat Tours | Waheed Murad Tourism')

@section('content')
    @php
        $cruises = [
            ['title' => 'Luxury Dubai Marina Cruise', 'image' => 'images/cruise-dubai-marina.png', 'tag' => 'Luxury yacht', 'description' => 'Sail past Dubai Marina’s iconic skyline with space to relax, celebrate and enjoy the view.', 'price' => 'PKR 16,158'],
            ['title' => 'Sunset Dhow Dinner Cruise', 'image' => 'images/dubai-adventure.png', 'tag' => 'Dinner cruise', 'description' => 'A relaxed evening on the water with a glowing skyline, dinner and gentle marina views.', 'price' => 'PKR 10,157'],
            ['title' => 'Palm & Atlantis Speedboat Tour', 'image' => 'images/cruise-dubai-marina.png', 'tag' => 'Speedboat', 'description' => 'See the city from a fresh perspective as you cruise from Dubai Marina towards Palm Jumeirah.', 'price' => 'PKR 11,157'],
            ['title' => 'Old Dubai Abra Journey', 'image' => 'images/airport-transfer.png', 'tag' => 'Heritage waterway', 'description' => 'Slow down and discover a classic side of Dubai with a scenic crossing on the historic creek.', 'price' => 'PKR 6,771'],
        ];
    @endphp

    <section class="sports-events-page cruise-page da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Cruise and Boat Tours']]" />
        <div class="sports-events-heading cruise-heading"><div><span class="sports-events-eyebrow">DUBAI FROM THE WATER</span><h1>Cruise &amp; <span>Boat Tours</span></h1><p>Discover Dubai from a different angle — from relaxed dhow dinners and marina cruises to exhilarating speedboat journeys.</p></div><a href="{{ url('/') }}#booking" class="sports-events-plan">Plan your cruise <span aria-hidden="true">→</span></a></div>

        <div class="cruise-benefits"><span><b>⌖</b><i>Location</i><strong>Dubai Marina &amp; Creek</strong></span><span><b>☼</b><i>Best time</i><strong>Sunset to evening</strong></span><span><b>♧</b><i>On board</i><strong>Dining &amp; refreshments</strong></span><span><b>◷</b><i>Duration</i><strong>1 to 3 hours</strong></span></div>

        <div class="sports-events-layout">
            <aside class="sports-events-filter" aria-label="Cruise filters"><div class="sports-filter-heading"><strong>Find your cruise</strong><span>4 experiences</span></div><details open><summary>Category <b>⌃</b></summary><label><input type="checkbox" checked> Cruise &amp; Boat Tours</label></details><details open><summary>Location <b>⌃</b></summary><label><input type="checkbox"> Dubai</label></details><details open><summary>Experience type <b>⌃</b></summary><label><input type="checkbox"> Luxury yacht</label><label><input type="checkbox"> Dinner cruise</label><label><input type="checkbox"> Speedboat</label></details><div class="sports-filter-help"><span aria-hidden="true">✦</span><p>Not sure which cruise?<br><a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Ask our local team</a></p></div></aside>
            <div class="sports-events-results"><div class="sports-results-bar"><strong><span>{{ count($cruises) }}</span> cruises to explore</strong><label>Sort by <select><option>Most popular</option><option>Price: Low to high</option><option>Price: High to low</option></select></label></div><div class="sports-event-list">@foreach ($cruises as $cruise)<article class="sports-event-card"><img src="{{ asset($cruise['image']) }}" alt="{{ $cruise['title'] }}" loading="lazy"><div class="sports-event-copy"><span>{{ $cruise['tag'] }}</span><h2>{{ $cruise['title'] }}</h2><p>{{ $cruise['description'] }}</p><small>⌖ Dubai</small></div><div class="sports-event-action"><small>From</small><strong>{{ $cruise['price'] }}</strong><a href="{{ url('/') }}#booking">Book now <span aria-hidden="true">→</span></a></div></article>@endforeach</div><p class="sports-events-note">You’ve explored all {{ count($cruises) }} cruise experiences.</p></div>
        </div>

        <section class="cruise-story"><div class="cruise-story-heading"><span>DISCOVER DUBAI FROM THE WATER</span><h2>Every skyline tells a story from the <em>sea.</em></h2></div><article><img src="{{ asset('images/cruise-dubai-marina.png') }}" alt="Dubai Marina yacht cruise" loading="lazy"><div><h3>Explore in effortless style</h3><p>Whether you choose a sunset cruise or an exhilarating speedboat ride, every journey is designed around standout views, easy moments and the Dubai skyline.</p><a href="{{ url('/') }}#booking">Find your perfect cruise <span aria-hidden="true">→</span></a></div></article><article class="cruise-story-reverse"><div><h3>Moments made for the water</h3><p>Bring friends, family or someone special for a city escape that feels wonderfully different from the shore.</p><a href="{{ url('/') }}#booking">Plan a private moment <span aria-hidden="true">→</span></a></div><img src="{{ asset('images/dubai-adventure.png') }}" alt="Dubai waterfront skyline" loading="lazy"></article></section>

        <section class="cruise-faq"><h2>Boat tours and cruises: Frequently asked <span>questions</span></h2><details><summary>What should I wear on a boat tour or cruise?<b>+</b></summary><p>Comfortable, light clothing and flat footwear are ideal for time on board.</p></details><details><summary>What should I bring on the boat tour?<b>+</b></summary><p>Bring sun protection, your camera and any personal essentials for your time on the water.</p></details><details><summary>Is Dubai Marina worth a visit?<b>+</b></summary><p>Yes — it is one of Dubai’s most scenic waterfront districts, particularly around sunset.</p></details></section>
    </section>
@endsection
