<aside class="wmt-admin-sidebar">
    <a class="wmt-admin-brand" href="{{ route('admin.dashboard') }}" aria-label="Open WMT admin dashboard">
        <img src="{{ asset('images/waheed-murad-tourism-logo.jpeg') }}" alt="Waheed Murad Tourism">
        <span><strong>WAHEED MURAD</strong><small>TOURISM · ADMIN</small></span>
    </a>

    <p class="wmt-admin-label">WORKSPACE</p>
    <nav class="wmt-admin-nav" aria-label="Admin navigation">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"><i>▦</i> Overview</a>
        <a href="{{ route('admin.dashboard') }}#bookings"><i>▤</i> Bookings <b>12</b></a>
        <a href="{{ route('admin.dashboard') }}#experiences"><i>✦</i> Experiences</a>
        <a href="{{ route('admin.dashboard') }}#guests"><i>◎</i> Guests</a>
        <a href="{{ route('admin.dashboard') }}#reports"><i>⌁</i> Reports</a>

        <details class="wmt-admin-menu" {{ request()->routeIs('admin.desert-adventures.*') ? 'open' : '' }}>
            <summary><i>▦</i><span>Category</span><b>⌄</b></summary>
            <div class="wmt-admin-menu-panel">
                <details class="wmt-admin-submenu" {{ request()->routeIs('admin.desert-adventures.*') ? 'open' : '' }}>
                    <summary><span>Desert Adventures</span><b>⌄</b></summary>
                    <a href="{{ route('admin.desert-adventures.index') }}" class="{{ request()->routeIs('admin.desert-adventures.index') ? 'is-active' : '' }}">All adventures</a>
                    <a href="{{ route('admin.desert-adventures.create') }}" class="{{ request()->routeIs('admin.desert-adventures.create') ? 'is-active' : '' }}">Create adventure</a>
                </details>
            </div>
        </details>
    </nav>

    <p class="wmt-admin-label">MANAGEMENT</p>
    <nav class="wmt-admin-nav" aria-label="Management navigation">
        <a href="{{ route('profile.edit') }}"><i>⚙</i> Account settings</a>
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
