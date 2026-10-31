@extends('layouts.desert-adventures')

@section('title', 'Dune Buggies | Waheed Murad Tourism')

@section('content')
    @php($adventures = $adventures ?? config('dune-buggies.adventures', []))
    <section class="da-category-hero da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Desert Adventures', 'url' => route('desert-adventures')], ['label' => 'Dune buggies']]" />
        <h1>Dune buggies</h1>
        <p>Take on the rolling sand dunes of the Dubai desert on a thrilling dune buggy experience. Ride as a passenger with one of our experienced drivers or get behind the wheel yourself as you enjoy an exhilarating journey in a specialist desert buggy. Strap on your helmet and goggles and take your seat in a unique vehicle where nothing but an unrivalled blast of adventure and unrivalled desert terrain is guaranteed.</p>
        <div class="da-feature-list" aria-label="Dune buggy experience highlights">
            <article><span>▱</span><div><b>Transfers from Dubai</b><small>Shared or Private</small></div></article><article><span>▱</span><div><b>Dune Drive</b><small>Two Hours</small></div></article><article><span>⌁</span><div><b>Equipment Provided</b><small>Helmets &amp; Goggles</small></div></article><article><span>☕</span><div><b>Drinks &amp; Refreshments</b><small>Soft Drinks &amp; More</small></div></article>
        </div>
    </section>

    <section class="da-container da-catalogue da-category-catalogue" aria-label="Dune buggy adventures">
        <aside class="da-filter-sidebar" data-filters>
            <div class="da-filter-heading"><strong>Filter by</strong><button type="button" data-filter-toggle aria-expanded="false">Filters <b>⌄</b></button></div>
            <div class="da-filter-groups" data-filter-groups>
                <details open><summary>Category <b>⌃</b></summary><p class="da-filter-parent">Desert Adventures</p><label><input type="checkbox" value="buggy" data-filter="category"> Dune buggies ({{ count($adventures) }})</label></details>
                <details open><summary>Location <b>⌃</b></summary><label><input type="checkbox" value="dubai" data-filter="location"> Dubai ({{ count($adventures) }})</label></details>
                <details><summary>Time <b>⌄</b></summary><label><input type="checkbox" value="morning" data-filter="time"> Morning</label><label><input type="checkbox" value="evening" data-filter="time"> Evening</label></details>
                <details><summary>Price <b>⌄</b></summary><label><input type="radio" name="price" value="2000" data-price-filter> Under AED 2,000</label><label><input type="radio" name="price" value="99999" data-price-filter> AED 2,000+</label></details>
                <details><summary>Language <b>⌄</b></summary><label><input type="checkbox"> English (3)</label></details>
            </div>
        </aside>
        <div class="da-results">
            <div class="da-results-top"><strong><span data-product-count>{{ count($adventures) }}</span> products found</strong><label>Sort by <select data-sort><option value="popular">Most Popular</option><option value="low">Price: Low to High</option><option value="high">Price: High to Low</option><option value="az">Name: A–Z</option></select></label></div>
            <div class="da-adventure-list" data-adventure-list>@foreach ($adventures as $adventure)<x-desert-adventures.adventure-card :adventure="$adventure" />@endforeach</div>
            <p class="da-no-results" data-no-results hidden>No dune buggy adventures match your filters. <button type="button" data-clear-filters>Clear filters</button></p>
            <div class="da-show-more-wrap da-category-count"><span data-showing-count>Showing {{ count($adventures) }} of {{ count($adventures) }} products</span></div>
        </div>
    </section>

    <section class="da-desert-story da-container da-category-story">
        <h2 class="da-section-title">Dune Buggies with <span>Waheed Murad Tourism</span></h2>
        <article class="da-story-row"><img src="{{ asset('images/desert-buggy-adventure.png') }}" alt="Dune buggy driving through the desert" loading="lazy"><div><h3>An experienced team of drivers</h3><p>Our immensely popular desert excursions are among the most iconic adventures in Dubai and the UAE. Our award-winning team of desert experts will be on hand to make sure you have a safe and enjoyable dune buggy experience. Built around your instructions, our guides share the tips you need before getting behind the wheel of the dune buggy.</p></div></article>
        <article class="da-story-row da-story-row--reverse"><div><h3>Dedicated trail in Lisaili</h3><p>Our dune buggy experiences take place on a dedicated driving trail in Lisaili, a short drive from the Dubai Desert Conservation Reserve. The exciting trail features a range of turns, bumps, dips and dunes so you can experience the incredible capabilities of a desert dune buggy.</p></div><img src="{{ asset('images/desert-dune-drive.png') }}" alt="Dubai desert dunes at sunset" loading="lazy"></article>
        <article class="da-story-row"><img src="{{ asset('images/safaris/dune-buggy-adventure.jpg') }}" alt="Dune buggies lined up in the desert" loading="lazy"><div><h3>Underpinned by sustainable practices</h3><p>A commitment to the preservation of the desert and its surroundings underpins all Waheed Murad activities, including dune buggy experiences. We make a conscious and consistent effort to protect the desert ecosystem and operate responsibly.</p></div></article>
    </section>

    <section class="da-container da-faq da-category-faq"><h2 class="da-section-title">Dubai Dune Buggies: Frequently asked <span>questions</span></h2><div class="da-faq-list"><details><summary>What is dune bashing?<b>+</b></summary><p>Dune bashing is an exhilarating off-road drive across the desert’s rolling sand dunes with an experienced desert driver.</p></details><details><summary>Are dune buggies safe?<b>+</b></summary><p>Yes. You are briefed before your experience and supplied with the appropriate safety equipment.</p></details><details><summary>Who can drive desert dune buggies in Dubai?<b>+</b></summary><p>Drivers must meet the experience requirements for their selected dune buggy adventure.</p></details><details><summary>Is it easy to drive a dune buggy?<b>+</b></summary><p>Our team provides a full safety and vehicle briefing before you set off on the trail.</p></details><details><summary>How much is it to drive dune buggies in Dubai?<b>+</b></summary><p>Prices vary by buggy type, duration, and whether you choose a combined desert experience.</p></details></div></section>
@endsection
