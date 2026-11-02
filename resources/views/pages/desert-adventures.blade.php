@extends('layouts.desert-adventures')

@section('title', 'Desert Adventures | Waheed Murad')

@section('content')
    <section class="da-intro da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Desert Adventures']]" />
        <h1>{{ $category->name }}</h1>
        <p>{{ $category->description }}</p>
        <h2 class="da-section-title">All Desert <span>Adventures</span></h2>
    </section>

    <section class="da-container da-catalogue" id="all-desert-adventures" aria-label="All desert adventures">
        <aside class="da-filter-sidebar" data-filters>
            <div class="da-filter-heading"><strong>Filter by</strong><button type="button" data-filter-toggle aria-expanded="false">Filters <b>⌄</b></button></div>
            <div class="da-filter-groups" data-filter-groups>
                <details open><summary>Category <b>⌃</b></summary>@foreach($subcategories as $subcategory)<label><input type="checkbox" value="{{ $subcategory->slug }}" data-filter="category"> {{ $subcategory->name }} ({{ $subcategory->tours_count }})</label>@endforeach</details>
                <details open><summary>Location <b>⌃</b></summary>@foreach($locations as $location => $count)<label><input type="checkbox" value="{{ \Illuminate\Support\Str::slug($location) }}" data-filter="location"> {{ $location }} ({{ $count }})</label>@endforeach</details>
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

    @if($contentBlocks->isNotEmpty())<section class="da-desert-story da-container">
        <h2 class="da-section-title da-story-title">Desert Adventures with <span>Waheed Murad</span></h2>
        @foreach($contentBlocks as $block)
            <article class="da-story-row {{ $block->layout === 'image_right' ? 'da-story-row--reverse' : '' }}">
                @if($block->layout === 'image_right')
                    <div><h3>{{ $block->heading }}</h3><p>{{ $block->body }}</p></div>
                @endif
                @if($block->image)
                    <img src="{{ str_starts_with($block->image, 'images/') ? asset($block->image) : asset('storage/'.$block->image) }}" alt="{{ $block->image_alt }}" loading="lazy">
                @endif
                @if($block->layout !== 'image_right')
                    <div><h3>{{ $block->heading }}</h3><p>{{ $block->body }}</p></div>
                @endif
            </article>
        @endforeach
    </section>@endif

    <section class="da-explore" aria-labelledby="explore-desert-adventures">
        <div class="da-container">
            <div class="da-explore-intro">
                <div>
                    <p>CHOOSE YOUR ADVENTURE</p>
                    <h2 id="explore-desert-adventures">Explore different desert <span>adventures</span></h2>
                    <span>From quiet sunrise moments to thrilling dune drives, find the Dubai desert experience that feels made for you.</span>
                </div>
                <a href="#all-desert-adventures">Browse all adventures <i>→</i></a>
            </div>

            <div class="da-explore-grid">@foreach($subcategories->take(3) as $index => $subcategory)@php($tour = $subcategory->tours->first())<a href="{{ url('/desert-adventures/'.$subcategory->slug) }}" class="da-explore-card">@if($tour)<img src="{{ $tour->imageUrl() }}" alt="{{ $subcategory->name }}" loading="lazy">@endif<b>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</b><span><small>{{ $subcategory->description ?: 'DISCOVER DUBAI' }}</small><strong>{{ $subcategory->name }}</strong><em>Explore <i>→</i></em></span></a>@endforeach</div>
        </div>
    </section>

    @if($faqs->isNotEmpty())<section class="da-container da-faq"><h2 class="da-section-title">{{ $category->name }}: Frequently asked <span>questions</span></h2><div class="da-faq-list">@foreach($faqs as $faq)<details><summary>{{ $faq->question }}<b>+</b></summary><p>{{ $faq->answer }}</p></details>@endforeach</div></section>@endif
@endsection
