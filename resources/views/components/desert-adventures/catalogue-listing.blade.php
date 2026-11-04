@props(['items', 'label', 'title', 'description'])

@php
    $categories = $items->countBy('category_name')->sortKeys();
    $locations = $items->countBy('location_label')->sortKeys();
@endphp

<section class="da-intro da-container">
    <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => $label]]" />
    <h1>{{ $title }}</h1>
    <p>{{ $description }}</p>
    <h2 class="da-section-title">All <span>{{ $label }}</span></h2>
</section>

<section class="da-container da-catalogue" aria-label="{{ $label }} catalogue">
    <aside class="da-filter-sidebar" data-filters>
        <div class="da-filter-heading"><strong>Filter by</strong><button type="button" data-filter-toggle aria-expanded="false">Filters <b>⌄</b></button></div>
        <div class="da-filter-groups" data-filter-groups>
            @if($categories->count() > 1)<details open><summary>Category <b>⌃</b></summary>@foreach($categories as $category => $count)<label><input type="checkbox" value="{{ \Illuminate\Support\Str::slug($category) }}" data-filter="category"> {{ $category }} ({{ $count }})</label>@endforeach</details>@endif
            <details open><summary>Location <b>⌃</b></summary>@foreach($locations as $location => $count)<label><input type="checkbox" value="{{ \Illuminate\Support\Str::slug($location) }}" data-filter="location"> {{ $location }} ({{ $count }})</label>@endforeach</details>
            <details><summary>Price <b>⌄</b></summary><label><input type="radio" name="price" value="15000" data-price-filter> Under PKR 15,000</label><label><input type="radio" name="price" value="50000" data-price-filter data-price-min="15000"> PKR 15,000–50,000</label><label><input type="radio" name="price" value="999999999" data-price-filter data-price-min="50000"> PKR 50,000+</label></details>
        </div>
    </aside>
    <div class="da-results">
        <div class="da-results-top"><strong><span data-product-count>{{ $items->count() }}</span> products found</strong><label>Sort by <select data-sort><option value="popular">Most Popular</option><option value="low">Price: Low to High</option><option value="high">Price: High to Low</option><option value="az">Name: A–Z</option></select></label></div>
        <div class="da-adventure-list" data-adventure-list>@forelse($items as $item)<x-desert-adventures.adventure-card :adventure="$item" />@empty<p class="da-no-results">No experiences are available yet.</p>@endforelse</div>
        <p class="da-no-results" data-no-results hidden>No experiences match your filters. <button type="button" data-clear-filters>Clear filters</button></p>
        <div class="da-show-more-wrap"><span data-showing-count>Showing {{ min(6, $items->count()) }} of {{ $items->count() }} products</span><button type="button" data-show-more>Show more</button></div>
    </div>
</section>
