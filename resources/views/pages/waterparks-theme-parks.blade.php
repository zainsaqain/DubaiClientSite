@extends('layouts.desert-adventures')

@section('title', 'Waterparks & Theme Parks | Waheed Murad Tourism')

@section('content')
    @php
        $parks = [
            ['title' => 'Dubai Parks and Resorts', 'image' => 'images/dubai-attractions.png', 'tag' => 'Theme park', 'description' => 'A full day of rides, stories and family fun across Dubai’s favourite entertainment parks.', 'price' => 'PKR 22,699'],
            ['title' => 'Atlantis Aquaventure', 'image' => 'images/water-theme-parks-dubai.png', 'tag' => 'Waterpark', 'description' => 'Dive into slides, splash zones and ocean-inspired thrills at one of Dubai’s most iconic waterparks.', 'price' => 'PKR 31,932'],
            ['title' => 'IMG Worlds of Adventure', 'image' => 'images/global-village-dubai.png', 'tag' => 'Indoor adventure', 'description' => 'Step into an air-conditioned world of big rides, favourite characters and all-day entertainment.', 'price' => 'PKR 28,085'],
            ['title' => 'Ski Dubai Snow Park', 'image' => 'images/hero-dubai-aquarium.png', 'tag' => 'Indoor snow', 'description' => 'Swap the sunshine for snowy slopes, winter activities and memorable family moments.', 'price' => 'PKR 19,236'],
            ['title' => 'Wild Wadi Waterpark', 'image' => 'images/water-theme-parks-dubai.png', 'tag' => 'Waterpark', 'description' => 'Cool off with exciting slides, wave pools and spectacular views close to Burj Al Arab.', 'price' => 'PKR 19,929'],
        ];
    @endphp

    <section class="sports-events-page waterparks-page da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Waterparks & Theme Parks']]" />

        <div class="sports-events-heading waterparks-heading">
            <div><span class="sports-events-eyebrow">FAMILY FUN IN DUBAI</span><h1>Waterparks &amp; <span>Theme Parks</span></h1><p>Make every day in Dubai more memorable with splash-filled adventures, thrilling rides and attractions for every age.</p></div>
            <a href="{{ url('/') }}#booking" class="sports-events-plan">Plan a family day <span aria-hidden="true">→</span></a>
        </div>

        <div class="waterparks-highlights" aria-label="Waterparks highlights"><span><b>☼</b>Outdoor water fun</span><span><b>★</b>Thrill rides</span><span><b>♧</b>Family favourites</span><span><b>◷</b>Easy booking</span></div>

        <div class="sports-events-layout">
            <aside class="sports-events-filter" aria-label="Waterparks filters">
                <div class="sports-filter-heading"><strong>Find your day out</strong><span>{{ count($parks) }} experiences</span></div>
                <details open><summary>Category <b>⌃</b></summary><label><input type="checkbox" checked> Waterparks &amp; Theme Parks</label></details>
                <details open><summary>Location <b>⌃</b></summary><label><input type="checkbox"> Dubai</label></details>
                <details open><summary>Experience type <b>⌃</b></summary><label><input type="checkbox"> Waterparks</label><label><input type="checkbox"> Theme parks</label><label><input type="checkbox"> Family tickets</label></details>
                <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>Planning with children?<br><a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Ask our local team</a></p></div>
            </aside>

            <div class="sports-events-results">
                <div class="sports-results-bar"><strong><span>{{ count($parks) }}</span> experiences to explore</strong><label>Sort by <select><option>Most popular</option><option>Price: Low to high</option><option>Price: High to low</option></select></label></div>
                <div class="sports-event-list">
                    @foreach ($parks as $park)
                        <article class="sports-event-card waterpark-card">
                            <img src="{{ asset($park['image']) }}" alt="{{ $park['title'] }}" loading="lazy">
                            <div class="sports-event-copy"><span>{{ $park['tag'] }}</span><h2>{{ $park['title'] }}</h2><p>{{ $park['description'] }}</p><small>⌖ Dubai</small></div>
                            <div class="sports-event-action"><small>From</small><strong>{{ $park['price'] }}</strong><a href="{{ url('/') }}#booking">Book now <span aria-hidden="true">→</span></a></div>
                        </article>
                    @endforeach
                </div>
                <p class="sports-events-note">You’ve explored all {{ count($parks) }} park experiences.</p>
            </div>
        </div>

        <section class="waterparks-callout"><div><span>MAKE A SPLASH</span><h2>A Dubai day out the whole family will remember.</h2><p>From fast slides to amazing worlds, our local team makes it simple to choose the right experience for your group.</p></div><a href="{{ url('/') }}#booking">Start planning <span aria-hidden="true">→</span></a></section>
    </section>
@endsection
