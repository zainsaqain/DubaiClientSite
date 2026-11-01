<button class="wmt-admin-mobile-toggle" type="button" data-admin-sidebar-toggle aria-controls="wmt-admin-sidebar" aria-expanded="false" aria-label="Open admin menu">
    <span></span><span></span><span></span>
</button>
<div class="wmt-admin-sidebar-overlay" data-admin-sidebar-overlay></div>

<aside class="wmt-admin-sidebar" id="wmt-admin-sidebar" data-admin-sidebar>
    <button class="wmt-admin-sidebar-close" type="button" data-admin-sidebar-close aria-label="Close admin menu">×</button>
    <a class="wmt-admin-brand" href="{{ route('admin.dashboard') }}" aria-label="Open WMT admin dashboard">
        <img src="{{ asset('images/waheed-murad-tourism-logo.jpeg') }}" alt="Waheed Murad Tourism">
        <span><strong>WAHEED MURAD</strong><small>TOURISM · ADMIN</small></span>
    </a>

    <p class="wmt-admin-label">HOME</p>
    <nav class="wmt-admin-nav" aria-label="Home page navigation">
        <details class="wmt-admin-menu" {{ request()->routeIs('admin.home.hero.*') || request()->routeIs('admin.home.promo-cards.*') || request()->routeIs('admin.home.signature-journeys.*') || request()->routeIs('admin.home.testimonials.*') ? 'open' : '' }}>
            <summary><i>⌂</i><span>Home</span><b>⌄</b></summary>
            <div class="wmt-admin-menu-panel">
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.home.hero.*') ? 'open' : '' }}>
                    <summary><span>Hero</span><b>⌄</b></summary>
                    <a href="{{ route('admin.home.hero.index') }}" class="{{ request()->routeIs('admin.home.hero.index') ? 'is-active' : '' }}">Index</a>
                    <a href="{{ route('admin.home.hero.create') }}" class="{{ request()->routeIs('admin.home.hero.create') ? 'is-active' : '' }}">Create</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.home.promo-cards.*') ? 'open' : '' }}>
                    <summary><span>Promo Cards</span><b>⌄</b></summary>
                    <a href="{{ route('admin.home.promo-cards.index') }}" class="{{ request()->routeIs('admin.home.promo-cards.index') ? 'is-active' : '' }}">Index</a>
                    <a href="{{ route('admin.home.promo-cards.create') }}" class="{{ request()->routeIs('admin.home.promo-cards.create') ? 'is-active' : '' }}">Create</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.home.signature-journeys.*') ? 'open' : '' }}>
                    <summary><span>Signature Journey</span><b>⌄</b></summary>
                    <a href="{{ route('admin.home.signature-journeys.index') }}" class="{{ request()->routeIs('admin.home.signature-journeys.index') ? 'is-active' : '' }}">Index</a>
                    <a href="{{ route('admin.home.signature-journeys.create') }}" class="{{ request()->routeIs('admin.home.signature-journeys.create') ? 'is-active' : '' }}">Create</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.home.testimonials.*') ? 'open' : '' }}>
                    <summary><span>Testimonials</span><b>⌄</b></summary>
                    <a href="{{ route('admin.home.testimonials.index') }}" class="{{ request()->routeIs('admin.home.testimonials.index') ? 'is-active' : '' }}">Index</a>
                    <a href="{{ route('admin.home.testimonials.create') }}" class="{{ request()->routeIs('admin.home.testimonials.create') ? 'is-active' : '' }}">Create</a>
                </details>
            </div>
        </details>
    </nav>

    <p class="wmt-admin-label">WORKSPACE</p>
    <nav class="wmt-admin-nav" aria-label="Admin navigation">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"><i>▦</i> Overview</a>
        <a href="{{ route('admin.dashboard') }}#bookings"><i>▤</i> Bookings <b>12</b></a>
        <a href="{{ route('admin.dashboard') }}#experiences"><i>✦</i> Experiences</a>
        <a href="{{ route('admin.dashboard') }}#guests"><i>◎</i> Guests</a>
        <a href="{{ route('admin.dashboard') }}#reports"><i>⌁</i> Reports</a>

        <details class="wmt-admin-menu" {{ request()->routeIs('admin.tours.*') || request()->routeIs('admin.tour-categories.*') || request()->routeIs('admin.tour-subcategories.*') || request()->routeIs('admin.tour-features.*') ? 'open' : '' }}>
            <summary><i>✦</i><span>Tours Management</span><b>⌄</b></summary>
            <div class="wmt-admin-menu-panel">
                <a href="{{ route('admin.tours.index') }}" class="{{ request()->routeIs('admin.tours.index') || request()->routeIs('admin.tours.show') ? 'is-active' : '' }}">All Tours</a>
                <a href="{{ route('admin.tours.create') }}" class="{{ request()->routeIs('admin.tours.create') || request()->routeIs('admin.tours.edit') ? 'is-active' : '' }}">Add New Tour</a>
                <a href="{{ route('admin.tour-categories.index') }}" class="{{ request()->routeIs('admin.tour-categories.*') ? 'is-active' : '' }}">Categories</a>
                <a href="{{ route('admin.tour-subcategories.index') }}" class="{{ request()->routeIs('admin.tour-subcategories.*') ? 'is-active' : '' }}">Subcategories</a>
                <a href="{{ route('admin.tour-features.index') }}" class="{{ request()->routeIs('admin.tour-features.*') ? 'is-active' : '' }}">Tour Features</a>
            </div>
        </details>

        <details class="wmt-admin-menu" {{ request()->routeIs('admin.desert-adventures.*') || request()->routeIs('admin.sports-events.*') || request()->routeIs('admin.cruise-boat-tours.*') || request()->routeIs('admin.attractions.*') || request()->routeIs('admin.city-tours.*') || request()->routeIs('admin.waterparks-theme-parks.*') || request()->routeIs('admin.transfers.*') || request()->routeIs('admin.why-us.*') ? 'open' : '' }}>
            <summary><i>▦</i><span>Category</span><b>⌄</b></summary>
            <div class="wmt-admin-menu-panel">
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.desert-adventures.*') ? 'open' : '' }}>
                    <summary><span>Desert Adventures</span><b>⌄</b></summary>
                    <a href="{{ route('admin.desert-adventures.index') }}" class="{{ request()->routeIs('admin.desert-adventures.index') ? 'is-active' : '' }}">All adventures</a>
                    <a href="{{ route('admin.desert-adventures.create') }}" class="{{ request()->routeIs('admin.desert-adventures.create') ? 'is-active' : '' }}">Create adventure</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.sports-events.*') ? 'open' : '' }}>
                    <summary><span>Sports Events</span><b>⌄</b></summary>
                    <a href="{{ route('admin.sports-events.index') }}" class="{{ request()->routeIs('admin.sports-events.index') ? 'is-active' : '' }}">All events</a>
                    <a href="{{ route('admin.sports-events.create') }}" class="{{ request()->routeIs('admin.sports-events.create') ? 'is-active' : '' }}">Create event</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.cruise-boat-tours.*') ? 'open' : '' }}>
                    <summary><span>Cruise &amp; Boat Tours</span><b>⌄</b></summary>
                    <a href="{{ route('admin.cruise-boat-tours.index') }}" class="{{ request()->routeIs('admin.cruise-boat-tours.index') ? 'is-active' : '' }}">All tours</a>
                    <a href="{{ route('admin.cruise-boat-tours.create') }}" class="{{ request()->routeIs('admin.cruise-boat-tours.create') ? 'is-active' : '' }}">Create tour</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.attractions.*') ? 'open' : '' }}>
                    <summary><span>Attractions</span><b>⌄</b></summary>
                    <a href="{{ route('admin.attractions.index') }}" class="{{ request()->routeIs('admin.attractions.index') ? 'is-active' : '' }}">All attractions</a>
                    <a href="{{ route('admin.attractions.create') }}" class="{{ request()->routeIs('admin.attractions.create') ? 'is-active' : '' }}">Create attraction</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.city-tours.*') ? 'open' : '' }}>
                    <summary><span>City Tours</span><b>⌄</b></summary>
                    <a href="{{ route('admin.city-tours.index') }}" class="{{ request()->routeIs('admin.city-tours.index') ? 'is-active' : '' }}">All city tours</a>
                    <a href="{{ route('admin.city-tours.create') }}" class="{{ request()->routeIs('admin.city-tours.create') ? 'is-active' : '' }}">Create city tour</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.waterparks-theme-parks.*') ? 'open' : '' }}>
                    <summary><span>Waterparks &amp; Theme Parks</span><b>⌄</b></summary>
                    <a href="{{ route('admin.waterparks-theme-parks.index') }}" class="{{ request()->routeIs('admin.waterparks-theme-parks.index') ? 'is-active' : '' }}">All park experiences</a>
                    <a href="{{ route('admin.waterparks-theme-parks.create') }}" class="{{ request()->routeIs('admin.waterparks-theme-parks.create') ? 'is-active' : '' }}">Create experience</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.transfers.*') ? 'open' : '' }}>
                    <summary><span>Transfers</span><b>⌄</b></summary>
                    <a href="{{ route('admin.transfers.index') }}" class="{{ request()->routeIs('admin.transfers.index') ? 'is-active' : '' }}">All transfers</a>
                    <a href="{{ route('admin.transfers.create') }}" class="{{ request()->routeIs('admin.transfers.create') ? 'is-active' : '' }}">Create transfer</a>
                </details>
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.why-us.*') ? 'open' : '' }}>
                    <summary><span>Why Us</span><b>⌄</b></summary>
                    <a href="{{ route('admin.why-us.index') }}" class="{{ request()->routeIs('admin.why-us.index') ? 'is-active' : '' }}">All sections</a>
                    <a href="{{ route('admin.why-us.create') }}" class="{{ request()->routeIs('admin.why-us.create') ? 'is-active' : '' }}">Create section</a>
                </details>
            </div>
        </details>
    </nav>

    <p class="wmt-admin-label">MANAGEMENT</p>
    <nav class="wmt-admin-nav" aria-label="Management navigation">
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'is-active' : '' }}"><i>⚙</i> Account settings</a>
        <a href="{{ route('home') }}"><i>↗</i> View website</a>
    </nav>

    <div class="wmt-admin-help">
        <span>✦</span><strong>Need a hand?</strong><p>WMT support is one message away.</p>
        <a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Chat on WhatsApp <i>→</i></a>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="wmt-admin-logout">
        @csrf
        <button type="submit"><span>↪</span> Sign out</button>
    </form>
</aside>
