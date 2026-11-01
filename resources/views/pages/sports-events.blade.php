@extends('layouts.desert-adventures')

@section('title', 'Sports Events | Waheed Murad Tourism')

@section('content')
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
                    @forelse ($events as $event)
                        <article class="sports-event-card">
                            <img src="{{ asset($event['image']) }}" alt="{{ $event['title'] }}" loading="lazy">
                            <div class="sports-event-copy"><span>{{ $event['tag'] }}</span><h2>{{ $event['title'] }}</h2><p>{{ $event['description'] }}</p><small>⌖ {{ $event['location'] }}</small></div>
                            <div class="sports-event-action"><small>From</small><strong>{{ $event['price'] }}</strong><a href="{{ $event['url'] ?? url('/') }}#booking">Book now <span aria-hidden="true">→</span></a></div>
                        </article>
                    @empty
                        <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>There are no live sports events yet. Please check back soon.</p></div>
                    @endforelse
                </div>
                <p class="sports-events-note">You’ve explored all {{ count($events) }} sports events.</p>
            </div>
        </div>
    </section>
@endsection
