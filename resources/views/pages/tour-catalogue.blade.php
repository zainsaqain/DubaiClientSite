@extends('layouts.desert-adventures')

@section('title', ($subcategory?->meta_title ?: $category?->meta_title ?: $pageTitle).' | Waheed Murad Tourism')

@section('meta_description', $pageDescription)

@section('content')
    @php
        $breadcrumbs = [['label' => 'Home', 'url' => route('home')]];

        if ($category) {
            $breadcrumbs[] = ['label' => $category->name, 'url' => route('tour-categories.show', $category)];
        }

        if ($subcategory) {
            $breadcrumbs[] = ['label' => $subcategory->name];
        }

        if (! $category) {
            $breadcrumbs[] = ['label' => 'Search experiences'];
        }
    @endphp

    <section class="da-intro da-container da-category-hero">
        <x-breadcrumb :items="$breadcrumbs" />
        <h1>{{ $pageTitle }}</h1>
        @if ($pageDescription)
            <p>{{ $pageDescription }}</p>
        @endif
    </section>

    @if ($subcategories->isNotEmpty())
        <section class="da-container da-public-subcategories" aria-label="{{ $category->name }} subcategories">
            @foreach ($subcategories as $catalogueSubcategory)
                <a href="{{ route('tour-subcategories.show', [$category, $catalogueSubcategory]) }}">{{ $catalogueSubcategory->name }} <span aria-hidden="true">→</span></a>
            @endforeach
        </section>
    @endif

    <section class="da-container da-catalogue da-category-catalogue" aria-label="{{ $pageTitle }} tours">
        <aside class="da-filter-sidebar da-catalogue-search">
            <div class="da-filter-heading"><strong>Find an experience</strong></div>
            <form method="GET" action="{{ $category ? ($subcategory ? route('tour-subcategories.show', [$category, $subcategory]) : route('tour-categories.show', $category)) : route('tours.search') }}">
                <label>Search activities<input type="search" name="q" value="{{ $filters['q'] ?? request('q') }}" placeholder="Tour or location"></label>
                @if (! $category)
                    <label>Category<input type="search" name="category" value="{{ $filters['category'] ?? request('category') }}" placeholder="Category"></label>
                    <label>Subcategory<input type="search" name="subcategory" value="{{ $filters['subcategory'] ?? request('subcategory') }}" placeholder="Subcategory"></label>
                    <label>Location<input type="search" name="location" value="{{ $filters['location'] ?? request('location') }}" placeholder="Location"></label>
                @endif
                <input type="hidden" name="sort" value="{{ $sort }}">
                <button type="submit" class="da-book-button">Search</button>
            </form>
        </aside>

        <div>
            <form class="da-results-top" method="GET" action="{{ $category ? ($subcategory ? route('tour-subcategories.show', [$category, $subcategory]) : route('tour-categories.show', $category)) : route('tours.search') }}">
                @foreach (request()->except(['page', 'sort']) as $name => $value)
                    @if (is_scalar($value) && $value !== '')
                        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                    @endif
                @endforeach
                <strong>{{ $tours->total() }} {{ Str::plural('experience', $tours->total()) }}</strong>
                <label>Sort by
                    <select name="sort" onchange="this.form.submit()">
                        <option value="featured" @selected($sort === 'featured')>Featured</option>
                        <option value="price_asc" @selected($sort === 'price_asc')>Price: low to high</option>
                        <option value="price_desc" @selected($sort === 'price_desc')>Price: high to low</option>
                        <option value="name" @selected($sort === 'name')>Name</option>
                    </select>
                </label>
            </form>

            <div class="da-adventure-list">
                @forelse ($tours as $tour)
                    <x-desert-adventures.adventure-card :adventure="$tour->toCatalogueArray()" />
                @empty
                    <p class="da-catalogue-empty">No active experiences match these filters.</p>
                @endforelse
            </div>

            @if ($tours->hasPages())
                <nav class="da-catalogue-pagination" aria-label="Experience pages">
                    @if ($tours->onFirstPage())
                        <span>Previous</span>
                    @else
                        <a href="{{ $tours->previousPageUrl() }}" rel="prev">Previous</a>
                    @endif
                    <strong>Page {{ $tours->currentPage() }} of {{ $tours->lastPage() }}</strong>
                    @if ($tours->hasMorePages())
                        <a href="{{ $tours->nextPageUrl() }}" rel="next">Next</a>
                    @else
                        <span>Next</span>
                    @endif
                </nav>
            @endif
        </div>
    </section>
@endsection
