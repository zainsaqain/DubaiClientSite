@extends('layouts.desert-adventures')

@section('title', 'Dubai City Tours | Waheed Murad Tourism')

@section('content')
    @php
        $catalogueTours = collect($tours)->map(function (array $tour): array {
            $rawPrice = $tour['price'] ?? 0;
            $price = is_numeric($rawPrice)
                ? (float) $rawPrice
                : (float) preg_replace('/[^\d.]/', '', str_replace(',', '', (string) $rawPrice));
            $location = trim((string) ($tour['location_tag'] ?? $tour['location'] ?? 'Dubai')) ?: 'Dubai';
            $tourLanguages = $tour['languages'] ?? ['English'];
            $tourLanguages = is_array($tourLanguages) ? $tourLanguages : [$tourLanguages];
            $tourLanguages = array_values(array_filter($tourLanguages));

            return [
                ...$tour,
                'category' => \Illuminate\Support\Str::slug((string) ($tour['category'] ?? 'city-tours')),
                'time' => \Illuminate\Support\Str::slug((string) ($tour['time'] ?? $tour['experience_time'] ?? 'flexible')),
                'location' => \Illuminate\Support\Str::slug($location),
                'location_tag' => $location,
                'vehicle' => \Illuminate\Support\Str::slug((string) ($tour['vehicle'] ?? 'standard')),
                'language' => \Illuminate\Support\Str::slug((string) ($tourLanguages[0] ?? 'English')),
                'price' => $price,
                'price_label' => $tour['price_label'] ?? (is_string($rawPrice) && ! is_numeric($rawPrice) ? $rawPrice : 'PKR '.number_format($price)),
                'gallery' => is_array($tour['gallery'] ?? null) ? $tour['gallery'] : [$tour['image'] ?? 'images/dubai-adventure.png'],
            ];
        })->values();

        $locations = $catalogueTours->groupBy('location')->map(function ($group, $slug): array {
            return ['slug' => $slug, 'label' => $group->first()['location_tag'] ?? \Illuminate\Support\Str::headline((string) $slug), 'count' => $group->count()];
        })->sortBy('label')->values();
        $times = $catalogueTours->groupBy('time')->map(function ($group, $slug): array {
            return ['slug' => $slug, 'label' => \Illuminate\Support\Str::headline(str_replace('-', ' ', (string) $slug)), 'count' => $group->count()];
        })->sortBy('label')->values();
        $catalogueLanguages = $catalogueTours->groupBy('language')->map(function ($group, $slug): array {
            return ['slug' => $slug, 'label' => \Illuminate\Support\Str::headline(str_replace('-', ' ', (string) $slug)), 'count' => $group->count()];
        })->sortBy('label')->values();
        $vehicles = $catalogueTours->groupBy('vehicle')->map(function ($group, $slug): array {
            return ['slug' => $slug, 'label' => \Illuminate\Support\Str::headline(str_replace('-', ' ', (string) $slug)), 'count' => $group->count()];
        })->sortBy('label')->values();
        $highestPrice = max(1, (int) $catalogueTours->max('price'));
        $priceStep = max(1, (int) ceil($highestPrice / 3));
        $priceRanges = [
            ['minimum' => 0, 'maximum' => $priceStep, 'label' => 'Up to PKR '.number_format($priceStep)],
            ['minimum' => $priceStep + 1, 'maximum' => $priceStep * 2, 'label' => 'PKR '.number_format($priceStep + 1).'–'.number_format($priceStep * 2)],
            ['minimum' => ($priceStep * 2) + 1, 'maximum' => $highestPrice, 'label' => 'PKR '.number_format(($priceStep * 2) + 1).'+'],
        ];
    @endphp

    <section class="da-intro da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'City Tours']]" />
        <h1>{{ $category?->name ?? 'City Tours' }}</h1>
        <p>{{ $category?->description ?: 'At Waheed Murad Tourism, choose from city tours across Dubai and the UAE, designed around the landmarks, culture and experiences you want to discover.' }}</p>
        <h2 class="da-section-title">All City <span>Tours</span></h2>
    </section>

    <section class="da-container da-catalogue" id="all-city-tours" aria-label="All city tours">
        <aside class="da-filter-sidebar" data-filters>
            <div class="da-filter-heading">
                <strong>Filter by</strong>
                <button type="button" data-filter-toggle aria-expanded="false">Filters <b>⌄</b></button>
            </div>
            <div class="da-filter-groups" data-filter-groups>
                <details open>
                    <summary>Category <b>⌃</b></summary>
                    <p class="da-filter-parent">{{ $category?->name ?? 'City Tours' }}</p>
                </details>
                <details open>
                    <summary>Location <b>⌃</b></summary>
                    @forelse ($locations as $location)
                        <label><input type="checkbox" value="{{ $location['slug'] }}" data-filter="location" data-filter-label="{{ $location['label'] }}"> {{ $location['label'] }} ({{ $location['count'] }})</label>
                    @empty
                        <p class="da-filter-parent">No locations available</p>
                    @endforelse
                </details>
                <details open>
                    <summary>Time <b>⌃</b></summary>
                    @forelse ($times as $time)
                        <label><input type="checkbox" value="{{ $time['slug'] }}" data-filter="time" data-filter-label="{{ $time['label'] }}"> {{ $time['label'] }} ({{ $time['count'] }})</label>
                    @empty
                        <p class="da-filter-parent">No time filters available</p>
                    @endforelse
                </details>
                <details open>
                    <summary>Price <b>⌃</b></summary>
                    @foreach ($priceRanges as $range)
                        <label><input type="radio" name="price" data-price-filter data-price-min="{{ $range['minimum'] }}" data-price-max="{{ $range['maximum'] }}" data-filter-label="{{ $range['label'] }}"> {{ $range['label'] }}</label>
                    @endforeach
                </details>
                <details open>
                    <summary>Language <b>⌃</b></summary>
                    @forelse ($catalogueLanguages as $language)
                        <label><input type="checkbox" value="{{ $language['slug'] }}" data-filter="language" data-filter-label="{{ $language['label'] }}"> {{ $language['label'] }} ({{ $language['count'] }})</label>
                    @empty
                        <p class="da-filter-parent">No languages available</p>
                    @endforelse
                </details>
                <details>
                    <summary>Vehicle Options <b>⌄</b></summary>
                    @forelse ($vehicles as $vehicle)
                        <label><input type="checkbox" value="{{ $vehicle['slug'] }}" data-filter="vehicle" data-filter-label="{{ $vehicle['label'] }}"> {{ $vehicle['label'] }} ({{ $vehicle['count'] }})</label>
                    @empty
                        <p class="da-filter-parent">No vehicle options available</p>
                    @endforelse
                </details>
            </div>
        </aside>

        <div class="da-results">
            <div class="da-results-top">
                <strong><span data-product-count>{{ $catalogueTours->count() }}</span> products found</strong>
                <label>Sort by
                    <select data-sort>
                        <option value="popular">Most Popular</option>
                        <option value="low">Price: Low to High</option>
                        <option value="high">Price: High to Low</option>
                        <option value="az">Name: A–Z</option>
                    </select>
                </label>
            </div>
            <div class="da-active-filter-summary" data-active-filter-summary hidden>
                <span>Filters: <b data-active-filter-label></b></span>
                <button type="button" data-clear-filters>Clear all filters</button>
            </div>
            <div class="da-adventure-list" data-adventure-list>
                @forelse ($catalogueTours as $adventure)
                    <x-desert-adventures.adventure-card :adventure="$adventure" />
                @empty
                    <p class="da-catalogue-empty">There are no live city tours yet. Please check back soon.</p>
                @endforelse
            </div>
            <p class="da-no-results" data-no-results hidden>No city tours match your filters. <button type="button" data-clear-filters>Clear filters</button></p>
            <div class="da-show-more-wrap">
                <span data-showing-count>Showing {{ min(6, $catalogueTours->count()) }} of {{ $catalogueTours->count() }} products</span>
                <button type="button" data-show-more>Show more</button>
            </div>
        </div>
    </section>

    @php
        $fallbackStories = [
            ['heading' => 'City experiences designed around you', 'body' => 'Explore the UAE through city tours that bring together landmark visits, cultural discoveries and time to enjoy each destination at your own pace.', 'image' => 'images/abu-dhabi/abu-dhabi-corniche.png', 'alt' => 'UAE city skyline'],
            ['heading' => 'Local insight for every itinerary', 'body' => 'Each experience can be reviewed alongside its tour details, location, inclusions and available options before you decide which city adventure is right for you.', 'image' => 'images/abu-dhabi/abu-dhabi-mosque.png', 'alt' => 'Abu Dhabi mosque'],
            ['heading' => 'More to discover across the UAE', 'body' => 'Browse active city-tour subcategories to find experiences focused on the places, attractions and travel styles you want to explore next.', 'image' => 'images/abu-dhabi/abu-dhabi-museum.png', 'alt' => 'Abu Dhabi museum'],
        ];
        $fallbackFaqs = [
            ['question' => 'How long does a city tour last?', 'answer' => 'Tour duration is shown on each tour page and can vary by itinerary and selected option.'],
            ['question' => 'What is included in a city tour?', 'answer' => 'Review the individual tour page for its current inclusions, options and practical information before booking.'],
            ['question' => 'Can I choose a city-tour destination?', 'answer' => 'Use the destination cards above to browse the active city-tour subcategories available on the website.'],
        ];
    @endphp

    <section class="da-abu-dhabi-page city-tours-reference-content">
        <section class="da-container da-abu-story" aria-labelledby="city-tours-story-heading">
            <div class="da-abu-story-heading">
                <h2 id="city-tours-story-heading">City Tours with <span>Waheed Murad Tourism</span></h2>
            </div>

            @if ($category && $category->contentBlocks->isNotEmpty())
                @foreach ($category->contentBlocks as $block)
                    @php
                        $fallback = $fallbackStories[$loop->index % count($fallbackStories)];
                        $blockImage = $block->image
                            ? (str_starts_with($block->image, 'images/') ? asset($block->image) : asset('storage/'.$block->image))
                            : asset($fallback['image']);
                    @endphp
                    <article class="da-abu-story-panel {{ in_array($block->layout, ['image_right', 'right'], true) ? 'da-abu-story-panel--reverse' : '' }}">
                        <img class="da-abu-story-image" src="{{ $blockImage }}" alt="{{ $block->image_alt ?: $fallback['alt'] }}">
                        <div><h3>{{ $block->heading }}</h3><p>{{ $block->body }}</p></div>
                    </article>
                @endforeach
            @else
                @foreach ($fallbackStories as $index => $story)
                    <article class="da-abu-story-panel {{ $index % 2 === 1 ? 'da-abu-story-panel--reverse' : '' }}">
                        <img class="da-abu-story-image" src="{{ asset($story['image']) }}" alt="{{ $story['alt'] }}">
                        <div><h3>{{ $story['heading'] }}</h3><p>{{ $story['body'] }}</p></div>
                    </article>
                @endforeach
            @endif
        </section>

        @if ($category && $category->subcategories->isNotEmpty())
            <section class="da-container city-tours-destination-section" aria-labelledby="city-tours-destinations-heading">
                <div class="da-abu-section-heading"><h2 id="city-tours-destinations-heading">City Tours across the <span>UAE</span></h2></div>
                <div class="city-tours-destination-grid">
                    @foreach ($category->subcategories as $destination)
                        <article>
                            <h3>{{ $destination->name }} City Tours</h3>
                            <p>{{ \Illuminate\Support\Str::limit($destination->description ?: 'Explore the available experiences in this city-tour destination.', 110) }}</p>
                            <a href="{{ route('city-tours.destination', $destination) }}">View tours <span aria-hidden="true">→</span></a>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="da-container da-abu-faq" aria-labelledby="city-tours-faq-heading">
            <h2 id="city-tours-faq-heading">Frequently asked <span>questions</span></h2>
            @if ($category && $category->faqs->isNotEmpty())
                @foreach ($category->faqs as $faq)
                    <details><summary>{{ $faq->question }} <span aria-hidden="true">+</span></summary><p>{{ $faq->answer }}</p></details>
                @endforeach
            @else
                @foreach ($fallbackFaqs as $faq)
                    <details><summary>{{ $faq['question'] }} <span aria-hidden="true">+</span></summary><p>{{ $faq['answer'] }}</p></details>
                @endforeach
            @endif
        </section>
    </section>
@endsection
