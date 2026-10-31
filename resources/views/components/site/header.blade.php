<header class="site-header" id="top">
    <div class="color-ribbon" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span><span></span></div>

    <div class="utility-bar">
        <div class="header-container utility-content">
            <p>Curated journeys across Dubai and the UAE</p>
            <div class="utility-links"><a href="{{ url('/') }}#contact">Travel support</a><span aria-hidden="true"></span><a href="{{ url('/') }}#booking">Manage booking</a></div>
        </div>
    </div>

    <div class="main-header">
        <div class="header-container brand-row">
            <a class="brand" href="{{ url('/') }}" aria-label="Waheed Murad Tourism home"><span class="brand-mark"><img src="{{ asset('images/waheed-murad-tourism-logo.jpeg') }}" alt="Waheed Murad Tourism"></span><span class="brand-copy"><strong>Waheed Murad</strong><small>Tourism</small></span></a>
            <div class="desktop-tools">
                <a class="quick-link" href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer" aria-label="Open WhatsApp chat with local travel expert"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.7a8.4 8.4 0 0 1-12.4 7.4L3.5 20.5l1.5-4.3A8.4 8.4 0 1 1 20.5 11.7Z"/><path d="M8.6 7.9c.2-.5.4-.5.7-.5h.5c.2 0 .4.1.5.4l.8 1.9c.1.2.1.4 0 .6l-.5.7c-.1.2-.1.3 0 .5.5 1 1.3 1.8 2.4 2.3.2.1.4.1.5 0l.8-.9c.2-.2.4-.2.6-.1l1.8.8c.3.1.4.3.4.5 0 .4-.2 1.2-.7 1.5-.3.2-.7.4-1.2.4-.7 0-1.5-.2-2.7-.8a10.3 10.3 0 0 1-4.3-4.1c-.8-1.2-1-2.1-1-2.8 0-.4.2-.8.4-1.1Z"/></svg><span><small>Talk to a local expert</small><b>WhatsApp us</b></span></a>
                <button class="header-search" type="button" aria-label="Search experiences" onclick="window.location.href='{{ url('/') }}#booking'"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.5"/><path d="m16 16 4.4 4.4"/></svg><span>Search experiences</span></button>
                <a class="plan-trip" href="{{ url('/') }}#booking">Plan your trip <span aria-hidden="true">→</span></a>
            </div>
            <div class="mobile-quick-actions" aria-label="Quick actions">
                <a class="mobile-icon-link" href="{{ url('/') }}#wishlist" aria-label="Wishlist, 0 items"><span class="action-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.8 4.9a5.3 5.3 0 0 0-7.5 0L12 6.2l-1.3-1.3a5.3 5.3 0 0 0-7.5 0L3.2 12.4 12 21l8.8-8.6a5.3 5.3 0 0 0 0-7.5Z"/></svg><b>0</b></span></a>
                <a class="mobile-icon-link" href="{{ url('/') }}#cart" aria-label="Cart, 0 items"><span class="action-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5.5 8.5h13l-.7 11H6.2l-.7-11Z"/><path d="M9 9V6.5a3 3 0 0 1 6 0V9"/></svg><b>0</b></span></a>
                <a class="mobile-icon-link whatsapp-mobile" href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer" aria-label="Chat with us on WhatsApp"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.7a8.4 8.4 0 0 1-12.4 7.4L3.5 20.5l1.5-4.3A8.4 8.4 0 1 1 20.5 11.7Z"/><path d="M8.6 7.9c.2-.5.4-.5.7-.5h.5c.2 0 .4.1.5.4l.8 1.9c.1.2.1.4 0 .6l-.5.7c-.1.2-.1.3 0 .5.5 1 1.3 1.8 2.4 2.3.2.1.4.1.5 0l.8-.9c.2-.2.4-.2.6-.1l1.8.8c.3.1.4.3.4.5 0 .4-.2 1.2-.7 1.5-.3.2-.7.4-1.2.4-.7 0-1.5-.2-2.7-.8a10.3 10.3 0 0 1-4.3-4.1c-.8-1.2-1-2.1-1-2.8 0-.4.2-.8.4-1.1Z"/></svg></a>
            </div>
            <button class="menu-toggle" type="button" aria-controls="mobile-navigation" aria-expanded="false"><span class="sr-only">Open navigation</span><i></i><i></i><i></i></button>
        </div>
    </div>

    <nav class="primary-navigation" aria-label="Main navigation">
        <div class="header-container navigation-row">
            <div class="nav-links">
                <div class="nav-item has-mega-menu {{ request()->is('desert-adventures*') ? 'is-active' : '' }}" data-mega-menu><a class="nav-trigger" href="{{ route('desert-adventures') }}" aria-expanded="false">Desert Adventures <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg></a><x-site.desert-adventures-mega-menu /></div>
                <div class="nav-item has-mega-menu {{ request()->routeIs('attractions') ? 'is-active' : '' }}" data-attractions-mega-menu><a class="nav-trigger" href="{{ route('attractions') }}" aria-expanded="false">Attractions <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg></a><x-site.attractions-mega-menu /></div><a class="{{ request()->routeIs('sports-events') ? 'is-active' : '' }}" href="{{ route('sports-events') }}">Sports Events</a><div class="nav-item has-mega-menu {{ request()->routeIs('city-tours') ? 'is-active' : '' }}" data-city-tours-mega-menu><a class="nav-trigger" href="{{ route('city-tours') }}" aria-expanded="false">City Tours <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg></a><x-site.city-tours-mega-menu /></div><a class="{{ request()->routeIs('cruise-boat-tours') ? 'is-active' : '' }}" href="{{ route('cruise-boat-tours') }}">Cruise and Boat Tours</a><a class="{{ request()->routeIs('waterparks-theme-parks') ? 'is-active' : '' }}" href="{{ route('waterparks-theme-parks') }}">Waterparks &amp; Theme Parks</a><a class="{{ request()->routeIs('transfers') ? 'is-active' : '' }}" href="{{ route('transfers') }}">Transfers</a><div class="nav-item has-mega-menu {{ request()->routeIs('why-us') ? 'is-active' : '' }}" data-why-us-mega-menu><a class="nav-trigger" href="{{ route('why-us') }}" aria-expanded="false">Why us <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg></a><x-site.why-us-mega-menu /></div>
            </div>
            <div class="account-links">
                @auth
                    <a href="{{ url('/dashboard') }}" class="account-link"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 21a7.5 7.5 0 0 1 15 0"/></svg><span>My account</span></a>
                @else
                    <a href="{{ route('login') }}" class="account-link"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 21a7.5 7.5 0 0 1 15 0"/></svg><span>Sign in</span></a>
                @endauth
                <a class="header-action" href="{{ url('/') }}#wishlist" aria-label="Wishlist, 0 items"><span class="action-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.8 4.9a5.3 5.3 0 0 0-7.5 0L12 6.2l-1.3-1.3a5.3 5.3 0 0 0-7.5 0L3.2 12.4 12 21l8.8-8.6a5.3 5.3 0 0 0 0-7.5Z"/></svg><b>0</b></span><span>Wishlist</span></a>
                <a class="header-action" href="{{ url('/') }}#cart" aria-label="Cart, 0 items"><span class="action-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5.5 8.5h13l-.7 11H6.2l-.7-11Z"/><path d="M9 9V6.5a3 3 0 0 1 6 0V9"/></svg><b>0</b></span><span>Cart</span></a>
            </div>
        </div>
    </nav>

    <div class="mobile-navigation" id="mobile-navigation" hidden aria-hidden="true">
        <button class="mobile-menu-scrim" type="button" aria-label="Close navigation"></button>
        <aside class="mobile-menu-drawer" aria-label="Mobile navigation">
            <div class="mobile-menu-bar"><span>Explore Dubai</span><button class="mobile-menu-close" type="button" aria-label="Close navigation">×</button></div>
            <nav class="mobile-menu-main" aria-label="Mobile main navigation">
                <a class="mobile-menu-item" href="{{ route('desert-adventures') }}"><span class="mobile-nav-icon icon-dunes" aria-hidden="true">⌁</span><span>Desert Adventures</span><i aria-hidden="true">›</i></a>
                <a class="mobile-menu-item" href="{{ route('attractions') }}"><span class="mobile-nav-icon icon-attractions" aria-hidden="true">✦</span><span>Attractions</span><i aria-hidden="true">›</i></a>
                <a class="mobile-menu-item" href="{{ route('sports-events') }}"><span class="mobile-nav-icon icon-sports" aria-hidden="true">◉</span><span>Sports Events</span><i aria-hidden="true">›</i></a>
                <a class="mobile-menu-item" href="{{ route('city-tours') }}"><span class="mobile-nav-icon icon-city" aria-hidden="true">▥</span><span>City Tours</span><i aria-hidden="true">›</i></a>
                <a class="mobile-menu-item" href="{{ route('cruise-boat-tours') }}"><span class="mobile-nav-icon icon-cruise" aria-hidden="true">⌇</span><span>Cruise and Boat Tours</span><i aria-hidden="true">›</i></a>
                <a class="mobile-menu-item" href="{{ route('waterparks-theme-parks') }}"><span class="mobile-nav-icon icon-parks" aria-hidden="true">♧</span><span>Waterparks &amp; Theme Parks</span><i aria-hidden="true">›</i></a>
                <a class="mobile-menu-item" href="{{ route('transfers') }}"><span class="mobile-nav-icon icon-transfers" aria-hidden="true">↗</span><span>Transfers</span><i aria-hidden="true">›</i></a>
                <a class="mobile-menu-item {{ request()->routeIs('why-us') ? 'is-active' : '' }}" href="{{ route('why-us') }}"><span class="mobile-nav-icon icon-why" aria-hidden="true">♥</span><span>Why us</span><i aria-hidden="true">›</i></a>
            </nav>
            <div class="mobile-menu-actions">
                @auth
                    <a href="{{ url('/dashboard') }}">My account</a>
                @else
                    <a href="{{ route('login') }}">Sign in / Create account</a>
                @endauth
                <a class="mobile-plan-trip" href="{{ url('/') }}#booking">Plan your trip <span aria-hidden="true">→</span></a>
            </div>
            <x-site.desert-adventures-mega-menu mobile />
        </aside>
    </div>
</header>
