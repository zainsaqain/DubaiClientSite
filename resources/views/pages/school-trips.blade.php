@extends('layouts.desert-adventures')

@section('title', 'School Trips | Waheed Murad Tourism')

@section('content')
    @php($adventures = $adventures ?? config('school-trips.adventures', []))

    <section class="da-category-hero da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Desert Adventures', 'url' => route('desert-adventures')], ['label' => 'School Trips']]" />
        <h1>School Trips</h1>
        <p>Explore school-trip ideas designed around the desert’s wildlife, heritage and landscapes. Every live experience is managed by our team, with options for educational visits, group activities and guided outdoor learning.</p>
        <div class="da-feature-list">
            <article><span>✦</span><div><b>Learning moments</b><small>Desert heritage &amp; nature</small></div></article>
            <article><span>◌</span><div><b>Group-friendly</b><small>Thoughtful daytime options</small></div></article>
            <article><span>▱</span><div><b>Guided visits</b><small>Purposeful local itineraries</small></div></article>
            <article><span>♧</span><div><b>Flexible planning</b><small>Plans tailored to your group</small></div></article>
        </div>
    </section>

    <section class="da-container da-catalogue da-category-catalogue" aria-label="School trip adventures">
        <aside class="da-filter-sidebar" data-filters>
            <div class="da-filter-heading"><strong>Filter by</strong><button type="button" data-filter-toggle aria-expanded="false">Filters <b>⌄</b></button></div>
            <div class="da-filter-groups" data-filter-groups>
                <details open><summary>Category <b>⌃</b></summary><p class="da-filter-parent">Desert Adventures</p><label><input type="checkbox" value="school" data-filter="category"> School Trips ({{ count($adventures) }})</label></details>
                <details open><summary>Location <b>⌃</b></summary><label><input type="checkbox" value="dubai" data-filter="location"> Dubai</label><label><input type="checkbox" value="lisaili" data-filter="location"> Lisaili</label></details>
                <details><summary>Time <b>⌄</b></summary><label><input type="checkbox" value="morning" data-filter="time"> Morning</label><label><input type="checkbox" value="evening" data-filter="time"> Evening</label></details>
                <details><summary>Price <b>⌄</b></summary><label><input type="radio" name="price" value="1000" data-price-filter> Sample price under AED 1,000</label><label><input type="radio" name="price" value="99999" data-price-filter> Sample price AED 1,000+</label></details>
            </div>
        </aside>
        <div class="da-results">
            <div class="da-results-top"><strong><span data-product-count>{{ count($adventures) }}</span> products found</strong><label>Sort by <select data-sort><option value="popular">Most Popular</option><option value="low">Price: Low to High</option><option value="high">Price: High to Low</option><option value="az">Name: A–Z</option></select></label></div>
            <div class="da-adventure-list" data-adventure-list>@foreach ($adventures as $adventure)<x-desert-adventures.adventure-card :adventure="$adventure" />@endforeach</div>
            <p class="da-no-results" data-no-results hidden>No school trips match your filters. <button type="button" data-clear-filters>Clear filters</button></p>
            <div class="da-show-more-wrap da-category-count"><span data-showing-count>Showing {{ count($adventures) }} of {{ count($adventures) }} products</span></div>
        </div>
    </section>

    <section class="da-desert-story da-container da-category-story">
        <h2 class="da-section-title">Why learn with <span>us</span></h2>
        <article class="da-story-row"><img src="{{ asset('images/desert-safari.png') }}" alt="Desert landscape for a school trip" loading="lazy"><div><h3>Desert heritage</h3><p>Bring learning to life with guided moments that introduce students to the desert’s nature, heritage and wide-open landscapes.</p></div></article>
        <article class="da-story-row da-story-row--reverse"><div><h3>Guided group planning</h3><p>Our team can help shape a day around your group’s transport, access requirements, timings and learning priorities.</p></div><img src="{{ asset('images/desert-oasis-morning.png') }}" alt="Morning desert landscape" loading="lazy"></article>
    </section>

    <section class="da-container da-faq da-category-faq"><h2 class="da-section-title">School Trips: Frequently asked <span>questions</span></h2><div class="da-faq-list"><details><summary>Can a school trip be customised?<b>+</b></summary><p>Yes. Contact our team with your group size, learning goals and preferred date to shape the right itinerary.</p></details><details><summary>Are prices live?<b>+</b></summary><p>Prices shown are starting prices. Final group rates are confirmed when your trip details are shared with our team.</p></details><details><summary>How are safety and supervision handled?<b>+</b></summary><p>Transport, activity requirements and supervision arrangements are confirmed before the trip begins.</p></details></div></section>
@endsection
