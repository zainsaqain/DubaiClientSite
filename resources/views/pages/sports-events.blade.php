@extends('layouts.desert-adventures')

@section('title', 'Sports Events | Waheed Murad Tourism')

@section('content')
    @php
        $events = [
            [
                'title' => 'Dubai Championship Golf Day',
                'image' => 'images/sports-golf-dubai.png',
                'description' => 'A polished day on the fairway with championship atmosphere, skyline views and premium hospitality.',
                'location' => 'Dubai',
                'price' => 'PKR 100,028',
                'tag' => 'Golf',
            ],
            [
                'title' => 'Abu Dhabi Grand Prix Weekend',
                'image' => 'images/sports-events-dubai.png',
                'description' => 'Feel the energy of race weekend with a seamless UAE experience built around speed, spectacle and excitement.',
                'location' => 'Abu Dhabi',
                'price' => 'PKR 299,622',
                'tag' => 'Motorsport',
            ],
            [
                'title' => 'Dubai Sevens Rugby Experience',
                'image' => 'images/sports-rugby-dubai.png',
                'description' => 'A high-energy stadium day with world-class rugby, big-match atmosphere and unforgettable Dubai evenings.',
                'location' => 'Dubai',
                'price' => 'PKR 115,417',
                'tag' => 'Rugby',
            ],
            [
                'title' => 'Topgolf Dubai Evening',
                'image' => 'images/sports-golf-dubai.png',
                'description' => 'Bring your group together for golf, great food and city views in one of Dubai’s favourite social spots.',
                'location' => 'Dubai',
                'price' => 'PKR 13,850',
                'tag' => 'Leisure sport',
            ],
        ];
    @endphp

    <section class="sports-events-page da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Sports Events']]" />

        <div class="sports-events-heading">
            <div><span class="sports-events-eyebrow">LIVE THE MOMENT</span><h1>Sports <span>Events</span></h1><p>From championship golf to race weekends, discover standout sports experiences across the UAE.</p></div>
            <a href="{{ url('/') }}#booking" class="sports-events-plan">Plan your sports day <span aria-hidden="true">→</span></a>
        </div>

        <div class="sports-events-layout">
            <aside class="sports-events-filter" aria-label="Sports events filters">
                <div class="sports-filter-heading"><strong>Find your event</strong><span>4 experiences</span></div>
                <details open><summary>Category <b>⌃</b></summary><label><input type="checkbox" checked> Sports Events</label></details>
                <details open><summary>Location <b>⌃</b></summary><label><input type="checkbox"> Dubai</label><label><input type="checkbox"> Abu Dhabi</label></details>
                <details open><summary>Experience type <b>⌃</b></summary><label><input type="checkbox"> Motorsport</label><label><input type="checkbox"> Golf</label><label><input type="checkbox"> Stadium events</label></details>
                <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>Need help choosing?<br><a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Ask our local team</a></p></div>
            </aside>

            <div class="sports-events-results">
                <div class="sports-results-bar"><strong><span>{{ count($events) }}</span> sports events to explore</strong><label>Sort by <select><option>Most popular</option><option>Price: Low to high</option><option>Price: High to low</option></select></label></div>
                <div class="sports-event-list">
                    @foreach ($events as $event)
                        <article class="sports-event-card">
                            <img src="{{ asset($event['image']) }}" alt="{{ $event['title'] }}" loading="lazy">
                            <div class="sports-event-copy"><span>{{ $event['tag'] }}</span><h2>{{ $event['title'] }}</h2><p>{{ $event['description'] }}</p><small>⌖ {{ $event['location'] }}</small></div>
                            <div class="sports-event-action"><small>From</small><strong>{{ $event['price'] }}</strong><a href="{{ url('/') }}#booking">Book now <span aria-hidden="true">→</span></a></div>
                        </article>
                    @endforeach
                </div>
                <p class="sports-events-note">You’ve explored all {{ count($events) }} sports events.</p>
            </div>
        </div>
    </section>
@endsection
