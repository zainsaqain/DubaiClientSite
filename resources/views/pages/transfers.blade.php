@extends('layouts.desert-adventures')

@section('title', 'Transfers | Waheed Murad Tourism')

@section('content')
    @php
        $transfers = [
            ['title' => 'Dubai Airport Private Transfer', 'image' => 'images/airport-transfer.png', 'tag' => 'Airport service', 'description' => 'Meet your professional driver on arrival and travel comfortably from Dubai International Airport to your hotel or destination.', 'price' => 'PKR 9,618'],
            ['title' => 'Private Intercity Transfer', 'image' => 'images/dubai-adventure.png', 'tag' => 'Door to door', 'description' => 'A reliable private journey for your plans beyond Dubai, with flexible pickup and room for your travel essentials.', 'price' => 'PKR 35,560'],
        ];
    @endphp

    <section class="sports-events-page transfers-page da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Transfers']]" />

        <div class="sports-events-heading transfers-heading">
            <div><span class="sports-events-eyebrow">TRAVEL WITH EASE</span><h1>Private <span>Transfers</span></h1><p>From airport arrivals to private journeys beyond Dubai, travel in comfort with dependable door-to-door service.</p></div>
            <a href="{{ url('/') }}#booking" class="sports-events-plan">Arrange your transfer <span aria-hidden="true">→</span></a>
        </div>

        <div class="transfer-benefits"><span><b>⌖</b>Door-to-door service</span><span><b>◷</b>Flexible pickup times</span><span><b>★</b>Professional drivers</span></div>

        <div class="sports-events-layout">
            <aside class="sports-events-filter" aria-label="Transfer filters">
                <div class="sports-filter-heading"><strong>Find your transfer</strong><span>{{ count($transfers) }} services</span></div>
                <details open><summary>Category <b>⌃</b></summary><label><input type="checkbox" checked> Transfers</label></details>
                <details open><summary>Journey type <b>⌃</b></summary><label><input type="checkbox"> Airport transfer</label><label><input type="checkbox"> Private journey</label></details>
                <details open><summary>Price <b>⌃</b></summary><label><input type="checkbox"> Under PKR 15,000</label><label><input type="checkbox"> Premium service</label></details>
                <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>Need a custom route?<br><a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Talk to our local team</a></p></div>
            </aside>

            <div class="sports-events-results">
                <div class="sports-results-bar"><strong><span>{{ count($transfers) }}</span> transfer options</strong><label>Sort by <select><option>Most popular</option><option>Price: Low to high</option><option>Price: High to low</option></select></label></div>
                <div class="sports-event-list">
                    @foreach ($transfers as $transfer)
                        <article class="sports-event-card transfer-card">
                            <img src="{{ asset($transfer['image']) }}" alt="{{ $transfer['title'] }}" loading="lazy">
                            <div class="sports-event-copy"><span>{{ $transfer['tag'] }}</span><h2>{{ $transfer['title'] }}</h2><p>{{ $transfer['description'] }}</p><small>⌖ Dubai &amp; UAE</small></div>
                            <div class="sports-event-action"><small>From</small><strong>{{ $transfer['price'] }}</strong><a href="{{ url('/') }}#booking">Book now <span aria-hidden="true">→</span></a></div>
                        </article>
                    @endforeach
                </div>
                <p class="sports-events-note">You’ve explored all {{ count($transfers) }} transfer services.</p>
            </div>
        </div>

        <section class="transfer-callout"><div><span>LOCAL SUPPORT, ALL THE WAY</span><h2>Your Dubai journey starts before you arrive.</h2><p>Share your flight or pickup details and our team will help you choose a transfer that suits your group and schedule.</p></div><a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">WhatsApp us <span aria-hidden="true">→</span></a></section>
    </section>
@endsection
