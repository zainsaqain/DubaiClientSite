@extends('layouts.desert-adventures')

@section('title', 'Desert Adventures | Arabian Adventures')

@section('content')
    @php($adventures = config('desert-adventures.adventures', []))
    <section class="da-intro da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Desert Adventures']]" />
        <h1>Desert Adventures</h1>
        <p>We have an incredible choice of desert adventures in Arabian Adventures. Head out on an exciting excursion to the Dubai Desert Conservation Reserve (DDCR) with our discover desert hiking, soaring wildlife and culture. Push your heart-racing desert dune buggies, and more memorable desert experiences. Discover the wonders of the desert with us today.</p>
        <h2 class="da-section-title">All Desert <span>Adventures</span></h2>
    </section>

    <section class="da-container da-catalogue" aria-label="All desert adventures">
        <aside class="da-filter-sidebar" data-filters>
            <div class="da-filter-heading"><strong>Filter by</strong><button type="button" data-filter-toggle aria-expanded="false">Filters <b>⌄</b></button></div>
            <div class="da-filter-groups" data-filter-groups>
                <details open><summary>Category <b>⌃</b></summary><label><input type="checkbox" value="safari" data-filter="category"> Desert Safaris</label><label><input type="checkbox" value="experience" data-filter="category"> Desert Experiences</label><label><input type="checkbox" value="buggy" data-filter="category"> Dune Buggies</label></details>
                <details open><summary>Location <b>⌃</b></summary><label><input type="checkbox" value="dubai" data-filter="location"> Dubai</label><label><input type="checkbox" value="lisaili" data-filter="location"> Ras Al Khaimah / Lisaili</label></details>
                <details><summary>Time <b>⌄</b></summary><label><input type="checkbox" value="morning" data-filter="time"> Morning</label><label><input type="checkbox" value="evening" data-filter="time"> Evening</label></details>
                <details><summary>Price <b>⌄</b></summary><label><input type="radio" name="price" value="500" data-price-filter> Under AED 500</label><label><input type="radio" name="price" value="2000" data-price-filter> AED 500–2,000</label><label><input type="radio" name="price" value="99999" data-price-filter> AED 2,000+</label></details>
                <details><summary>Language <b>⌄</b></summary><label><input type="checkbox"> English</label><label><input type="checkbox"> Arabic</label></details>
                <details><summary>Vehicle Options <b>⌄</b></summary><label><input type="checkbox" value="4x4" data-filter="vehicle"> Private 4x4</label><label><input type="checkbox" value="buggy" data-filter="vehicle"> Dune Buggies</label><label><input type="checkbox" value="walk" data-filter="vehicle"> Walking</label></details>
            </div>
        </aside>
        <div class="da-results">
            <div class="da-results-top"><strong><span data-product-count>{{ count($adventures) }}</span> products found</strong><label>Sort by <select data-sort><option value="popular">Most Popular</option><option value="low">Price: Low to High</option><option value="high">Price: High to Low</option><option value="az">Name: A–Z</option></select></label></div>
            <div class="da-adventure-list" data-adventure-list>
                @foreach ($adventures as $adventure)
                    <x-desert-adventures.adventure-card :adventure="$adventure" />
                @endforeach
            </div>
            <p class="da-no-results" data-no-results hidden>No adventures match your filters. <button type="button" data-clear-filters>Clear filters</button></p>
            <div class="da-show-more-wrap"><span data-showing-count>Showing 6 of {{ count($adventures) }} products</span><button type="button" data-show-more>Show more</button></div>
        </div>
    </section>

    <section class="da-desert-story da-container">
        <h2 class="da-section-title da-story-title">Desert Adventures with <span>Arabian Adventures</span></h2>
        <article class="da-story-row"><img src="{{ asset('images/desert-safari.png') }}" alt="Desert guides smiling together" loading="lazy"><div><h3>An award-winning team of desert experts</h3><p>For over 25 years, our desert guides have created unforgettable adventures for visitors from across the world. Friends and solo travellers. Whether you’re seeking thrills, culture, relaxation or all three, our experienced team makes every journey special.</p></div></article>
        <article class="da-story-row da-story-row--reverse"><div><h3>The Dubai Desert Conservation Reserve</h3><p>The Dubai Desert Conservation Reserve is a protected setting for our desert adventures. It is home to an extraordinary variety of wildlife and plants, and offers an escape into the landscape that makes Dubai so unique.</p></div><img src="{{ asset('images/desert-oasis-morning.png') }}" alt="Wildlife walking in the desert" loading="lazy"></article>
        <article class="da-story-row"><img src="{{ asset('images/desert-dune-drive.png') }}" alt="Traveller enjoying a desert sunset" loading="lazy"><div><h3>A commitment to the desert</h3><p>Our desert adventures are underpinned by sustainability efforts as we endeavour to preserve the unspoilt beauty of the DDCR. Our sustainable adventure experiences are designed to protect this land while creating meaningful memories for generations to come.</p></div></article>
    </section>

    <section class="da-container da-explore"><h2 class="da-section-title">Explore different desert <span>adventures</span></h2><div class="da-explore-grid"><a href="{{ route('desert-safaris') }}" class="da-explore-card"><img src="{{ asset('images/desert-safari.png') }}" alt="Desert Safaris" loading="lazy"><span><strong>Desert Safaris</strong><small>Learn more →</small></span></a><a href="{{ route('dune-buggies-category') }}" class="da-explore-card"><img src="{{ asset('images/desert-buggy-adventure.png') }}" alt="Dune Buggies" loading="lazy"><span><strong>Dune Buggies</strong><small>Learn more →</small></span></a><a href="{{ route('desert-experiences') }}" class="da-explore-card"><img src="{{ asset('images/desert-camp-experience.png') }}" alt="Desert Experiences" loading="lazy"><span><strong>Desert Experiences</strong><small>Learn more →</small></span></a></div></section>

    <section class="da-container da-faq"><h2 class="da-section-title">Desert Adventures: Frequently asked <span>questions</span></h2><div class="da-faq-list"><details><summary>Where is the desert in Dubai?<b>+</b></summary><p>Dubai’s most accessible desert landscapes are a short drive from the city, with the Dubai Desert Conservation Reserve offering a protected and memorable setting.</p></details><details><summary>Can I go to the Dubai desert on my own?<b>+</b></summary><p>Guided adventures are the easiest way to explore responsibly, with expert drivers, carefully planned routes and local insight included.</p></details><details><summary>Is it cooler in the desert in Dubai?<b>+</b></summary><p>Desert temperatures are generally most comfortable at sunrise and after sunset, which is why morning and evening adventures are so popular.</p></details><details><summary>Why is the Dubai desert famous?<b>+</b></summary><p>Its sweeping dunes, wildlife, Bedouin heritage and warm hospitality make the desert one of Dubai’s most distinctive experiences.</p></details></div></section>
@endsection
