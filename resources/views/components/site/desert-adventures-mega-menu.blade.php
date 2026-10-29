@props(['mobile' => false])

@php
    $menu = config('desert-navigation');
    $urlFor = static function (array $item): string {
        return isset($item['route']) && \Illuminate\Support\Facades\Route::has($item['route'])
            ? route($item['route'])
            : url($item['url'] ?? '/desert-adventures');
    };
@endphp

@if ($mobile)
    <section class="mobile-submenu-panel" id="mobile-desert-menu" aria-label="Desert Adventures submenu" aria-hidden="true">
        <div class="mobile-menu-bar mobile-submenu-bar">
            <button class="mobile-menu-back" type="button"><span aria-hidden="true">‹</span> Back</button>
            <button class="mobile-menu-close" type="button" aria-label="Close navigation">×</button>
        </div>
        <div class="mobile-submenu-content">
            <p class="mobile-submenu-eyebrow">Discover the desert</p>
            <h2>Desert Adventures</h2>

            @foreach ($menu['categories'] as $category)
                <a class="mobile-submenu-category" href="{{ $urlFor($category) }}">
                    <img class="category-orb" src="{{ asset($category['image']) }}" alt="">
                    <span><b>{{ $category['label'] }}</b><small>{{ $category['description'] }}</small></span>
                    <i aria-hidden="true">›</i>
                </a>
            @endforeach

            <div class="mobile-top-picks">
                <p>Top picks of the month</p>
                @foreach ($menu['top_picks'] as $pick)
                    <a href="{{ $urlFor($pick) }}">{{ $pick['label'] }} <span aria-hidden="true">→</span></a>
                @endforeach
            </div>
        </div>
    </section>
@else
    <section class="mega-menu" id="desert-adventures-mega-menu" aria-label="Desert Adventures menu">
        <div class="mega-menu-grid">
            <section class="mega-categories" aria-labelledby="desert-categories-title">
                <p class="mega-eyebrow" id="desert-categories-title">Categories</p>
                @foreach ($menu['categories'] as $category)
                    <a class="mega-category" href="{{ $urlFor($category) }}">
                        <img class="category-orb" src="{{ asset($category['image']) }}" alt="">
                        <span><b>{{ $category['label'] }}</b><small>{{ $category['description'] }}</small></span>
                    </a>
                @endforeach
            </section>

            <section class="mega-picks" aria-labelledby="desert-picks-title">
                <p class="mega-eyebrow" id="desert-picks-title">Top picks of the month</p>
                @foreach ($menu['top_picks'] as $pick)
                    <a href="{{ $urlFor($pick) }}">{{ $pick['label'] }} <span aria-hidden="true">→</span></a>
                @endforeach
            </section>
        </div>
    </section>
@endif
