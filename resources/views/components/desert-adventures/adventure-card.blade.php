<article class="da-adventure-card" data-adventure data-category="{{ $adventure['category'] }}" data-time="{{ $adventure['time'] }}" data-location="{{ $adventure['location'] }}" data-vehicle="{{ $adventure['vehicle'] }}" data-price="{{ $adventure['price'] }}" data-title="{{ strtolower($adventure['title']) }}">
    <div class="da-card-image" data-card-carousel>
        @php($gallery = $adventure['gallery'] ?? [$adventure['image']])
        <div class="da-card-slides">
            @foreach ($gallery as $i => $img)
                <div class="da-card-slide {{ $i === 0 ? 'is-active' : '' }}">
                    <img src="{{ asset($img) }}" alt="{{ $adventure['title'] }}" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                </div>
            @endforeach
        </div>
        @if (count($gallery) > 1)
            <button class="da-card-prev" type="button" data-card-prev aria-label="Previous image">&#8249;</button>
            <button class="da-card-next" type="button" data-card-next aria-label="Next image">&#8250;</button>
            <div class="da-card-dots" aria-hidden="true">
                @foreach ($gallery as $i => $img)
                    <span class="da-card-dot {{ $i === 0 ? 'is-active' : '' }}" data-card-dot="{{ $i }}"></span>
                @endforeach
            </div>
        @endif
    </div>
    <div class="da-card-content">
        <span class="da-card-category">{{ $adventure['category_name'] ?? 'Desert Safaris' }}</span>
        <h3><a href="{{ isset($adventure['route']) ? route($adventure['route']) : (isset($adventure['url']) ? url($adventure['url']) : '#') }}">{{ $adventure['title'] }}</a></h3>
        <p>{{ $adventure['description'] }} <strong class="da-more-link">More</strong></p>
        <div class="da-card-tags">
            @if (!empty($adventure['is_bestseller']))
                <span class="da-badge-bestseller">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>
                    Bestseller
                </span>
            @endif
            @if (!empty($adventure['is_choice']))
                <span class="da-badge-choice">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3"/></svg>
                    2025 Travellers' Choice
                </span>
            @endif
            @if (!empty($adventure['location_tag']))
                <span class="da-badge-location">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M8 1.5a4.5 4.5 0 0 0-4.5 4.5c0 3.2 4.5 8.5 4.5 8.5s4.5-5.3 4.5-8.5A4.5 4.5 0 0 0 8 1.5Zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z"/></svg>
                    {{ $adventure['location_tag'] }}
                </span>
            @endif
        </div>
        <div class="da-card-bottom">
            <div class="da-card-price-wrap">
                <small>From</small>
                <strong>PKR {{ $adventure['pkr_price'] ?? number_format($adventure['price'] * 103) }}</strong>
            </div>
            <a href="{{ isset($adventure['route']) ? route($adventure['route']) : (isset($adventure['url']) ? url($adventure['url']) : '#') }}" class="da-book-button">Book now</a>
        </div>
    </div>
</article>
