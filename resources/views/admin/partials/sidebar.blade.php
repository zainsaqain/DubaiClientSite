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
        <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'is-active' : '' }}"><i>▤</i> Bookings</a>
        <a href="{{ route('admin.bank-transfer-payments.index') }}" class="{{ request()->routeIs('admin.bank-transfer-payments.*') ? 'is-active' : '' }}"><i>¤</i> Bank transfer payments @if ($pendingBankTransferPaymentCount > 0)<b aria-label="{{ $pendingBankTransferPaymentCount }} pending booking{{ $pendingBankTransferPaymentCount === 1 ? '' : 's' }}">{{ $pendingBankTransferPaymentCount }}</b>@endif</a>
        <a href="{{ route('admin.bank-transfer-settings.edit') }}" class="{{ request()->routeIs('admin.bank-transfer-settings.*') ? 'is-active' : '' }}"><i>⚙</i> Bank transfer settings</a>

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

    </nav>

    <p class="wmt-admin-label">MANAGEMENT</p>
    <nav class="wmt-admin-nav" aria-label="Management navigation">
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'is-active' : '' }}"><i>⚙</i> Account settings</a>
        <a href="{{ route('home') }}"><i>↗</i> View website</a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="wmt-admin-logout">
        @csrf
        <button type="submit"><span>↪</span> Sign out</button>
    </form>
</aside>
