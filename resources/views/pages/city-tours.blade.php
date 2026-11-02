@extends('layouts.desert-adventures')

@section('title', 'Dubai City Tours | Waheed Murad Tourism')

@section('content')
    <section class="sports-events-page city-tours-page da-container">
        <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'City Tours']]" />

        <div class="sports-events-heading city-tours-heading"><div><span class="sports-events-eyebrow">DISCOVER THE UAE</span><h1>Dubai <span>City Tours</span></h1><p>Discover stories, culture and extraordinary views with thoughtfully planned city tours across Dubai and the UAE.</p></div><a href="{{ url('/') }}#booking" class="sports-events-plan">Plan your city day <span aria-hidden="true">→</span></a></div>

        <div class="city-tours-highlights" aria-label="City tour highlights"><span><b>⌖</b>Dubai &amp; Abu Dhabi</span><span><b>✦</b>Expert local guides</span><span><b>◷</b>Flexible itineraries</span><span><b>♥</b>Private options</span></div>

        <div class="sports-events-layout">
            <aside class="sports-events-filter" aria-label="City tour filters">
                <div class="sports-filter-heading"><strong>Find your city tour</strong><span>{{ count($tours) }} experiences</span></div>
                <details open><summary>Category <b>⌃</b></summary><label><input type="checkbox" checked> City tours</label><label><input type="checkbox"> Private tours</label></details>
                <details open><summary>Destination <b>⌃</b></summary><label><input type="checkbox"> Dubai</label><label><input type="checkbox"> Abu Dhabi</label><label><input type="checkbox"> Sharjah &amp; Al Ain</label></details>
                <details open><summary>Tour style <b>⌃</b></summary><label><input type="checkbox"> Full day</label><label><input type="checkbox"> Heritage &amp; culture</label><label><input type="checkbox"> Private guide</label></details>
                <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>Need help choosing?<br><a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Ask our local team</a></p></div>
            </aside>

            <div class="sports-events-results">
                <div class="sports-results-bar"><strong><span>{{ count($tours) }}</span> city tours to explore</strong><label>Sort by <select><option>Most popular</option><option>Price: Low to high</option><option>Price: High to low</option></select></label></div>
                <div class="sports-event-list">
                    @forelse ($tours as $tour)
                        <article class="sports-event-card city-tour-card"><img src="{{ asset($tour['image']) }}" alt="{{ $tour['title'] }}" loading="lazy"><div class="sports-event-copy"><span>{{ $tour['tag'] }}</span><h2>{{ $tour['title'] }}</h2><p>{{ $tour['description'] }}</p><small>⌖ {{ $tour['location'] }}</small></div><div class="sports-event-action"><small>From</small><strong>{{ $tour['price'] }}</strong><a href="{{ $tour['url'] ?? url('/') }}#booking">Book now <span aria-hidden="true">→</span></a></div></article>
                    @empty
                        <div class="sports-filter-help"><span aria-hidden="true">✦</span><p>There are no live city tours yet. Please check back soon.</p></div>
                    @endforelse
                </div>
                <p class="sports-events-note">You’ve explored all {{ count($tours) }} city tours.</p>
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
