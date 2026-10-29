@extends('layouts.desert-adventures')

@section('title', 'School Trips | Waheed Murad Tourism')

@section('content')
    @php($adventures = config('school-trips.adventures', []))

    <section class="da-category-hero da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Desert Adventures', 'url' => route('desert-adventures')], ['label' => 'School Trips']]" />
        <h1>School Trips</h1>
        <p>Explore sample school-trip ideas designed around the desert’s wildlife, heritage and landscapes. Each page is a static preview so a future booking flow can add live group availability, educational options and safeguarding details without changing the frontend structure.</p>
        <div class="da-feature-list">
            <article><span>✦</span><div><b>Learning moments</b><small>Desert heritage &amp; nature</small></div></article>
            <article><span>◌</span><div><b>Group-friendly</b><small>Sample daytime options</small></div></article>
            <article><span>▱</span><div><b>Guided visits</b><small>Static itinerary previews</small></div></article>
            <article><span>♧</span><div><b>Flexible planning</b><small>Future group configuration</small></div></article>
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
        <article class="da-story-row"><img src="{{ asset('images/desert-safari.png') }}" alt="Desert landscape for a school-trip preview" loading="lazy"><div><h3>Desert heritage</h3><p>This static section demonstrates where future curriculum links, learning goals and teacher resources can be introduced without altering the category layout.</p></div></article>
        <article class="da-story-row da-story-row--reverse"><div><h3>Guided group planning</h3><p>Future group bookings can add confirmed transport, access requirements and supervision details while retaining the current visual presentation.</p></div><img src="{{ asset('images/desert-oasis-morning.png') }}" alt="Morning desert landscape" loading="lazy"></article>
    </section>

    <section class="da-container da-faq da-category-faq"><h2 class="da-section-title">School Trips: Frequently asked <span>questions</span></h2><div class="da-faq-list"><details><summary>Can a school trip be customised?<b>+</b></summary><p>Yes, a future booking system can collect group needs and build an appropriate itinerary. This frontend is only a sample preview.</p></details><details><summary>Are prices live?<b>+</b></summary><p>No. Every displayed price is sample data for layout and interaction testing only.</p></details><details><summary>How are safety and supervision handled?<b>+</b></summary><p>Final safety, transport and supervision arrangements must be confirmed through the future live booking process.</p></details></div></section>
@endsection
