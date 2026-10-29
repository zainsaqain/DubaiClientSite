@php
$heroSlides = [
    [
        'id' => 'dubai-adventure',
        'badge' => 'EXPLORE DUBAI',
        'heading' => "Discover Dubai's Best Attractions",
        'heading_highlight' => 'Best Attractions',
        'description' => 'Browse unforgettable experiences and make the most of your Dubai adventure.',
        'image' => asset('images/hero-dubai-aquarium.png'),
        'image_alt' => 'Mother and daughter enjoying a high-definition Dubai aquarium experience',
        'primary_btn' => [
            'text' => 'Book Now',
            'url' => '#attractions',
            'aria_label' => 'Book tickets for top Dubai attractions',
        ],
        'secondary_btn' => [
            'text' => 'Explore All',
            'url' => '#attractions',
            'aria_label' => 'Explore all Dubai attractions and theme parks',
        ],
        'features' => [
            ['name' => 'Iconic Places', 'icon' => 'sparkles'],
            ['name' => 'Family Fun', 'icon' => 'users'],
            ['name' => 'Easy Booking', 'icon' => 'calendar-check'],
        ],
    ],
    [
        'id' => 'airport-transfers',
        'badge' => 'DUBAI AIRPORT TRANSFERS',
        'heading' => 'Arrive in Dubai. Travel in Comfort.',
        'heading_highlight' => 'Travel in Comfort.',
        'description' => 'Enjoy pre-booked pick-up or drop-off between the airport and any hotel or residence in Dubai.',
        'image' => asset('images/airport-transfer.png'),
        'image_alt' => 'Luxury Dubai airport transfer with private chauffeur and SUV',
        'primary_btn' => [
            'text' => 'Book Now',
            'url' => '#transfers',
            'aria_label' => 'Book your Dubai airport transfer',
        ],
        'secondary_btn' => [
            'text' => 'How It Works',
            'url' => '#why-us',
            'aria_label' => 'Learn how Dubai airport transfers work',
        ],
        'features' => [
            ['name' => 'Door-to-door', 'icon' => 'route'],
            ['name' => 'Pre-booked', 'icon' => 'badge-check'],
            ['name' => 'Dubai-wide', 'icon' => 'map-pin'],
        ],
    ],
    [
        'id' => 'dubai-attractions',
        'badge' => 'EXPLORE DUBAI',
        'heading' => "Discover Dubai's Best Attractions",
        'heading_highlight' => 'Best Attractions',
        'description' => 'Browse unforgettable experiences and make the most of your Dubai adventure.',
        'image' => asset('images/hero-dubai-aquarium.png'),
        'image_alt' => 'Mother and daughter enjoying a high-definition Dubai aquarium experience',
        'primary_btn' => [
            'text' => 'Book Now',
            'url' => '#attractions',
            'aria_label' => 'Book tickets for top Dubai attractions',
        ],
        'secondary_btn' => [
            'text' => 'Explore All',
            'url' => '#attractions',
            'aria_label' => 'Explore all Dubai attractions and theme parks',
        ],
        'features' => [
            ['name' => 'Iconic Places', 'icon' => 'sparkles'],
            ['name' => 'Family Fun', 'icon' => 'users'],
            ['name' => 'Easy Booking', 'icon' => 'ticket'],
        ],
    ],
    [
        'id' => 'desert-safari',
        'badge' => 'DUBAI DESERT SAFARI',
        'heading' => 'Experience the Magic of the Desert',
        'heading_highlight' => 'Magic of the Desert',
        'description' => 'Ride the golden dunes, spot wildlife, enjoy desert dining and live entertainment.',
        'image' => asset('images/desert-safari.png'),
        'image_alt' => 'Dubai desert safari camel caravan trekking at sunset across golden sand dunes',
        'primary_btn' => [
            'text' => 'Book Now',
            'url' => '#desert-safaris',
            'aria_label' => 'Book your Dubai desert safari adventure',
        ],
        'secondary_btn' => [
            'text' => 'Explore Safari',
            'url' => '#desert-adventures',
            'aria_label' => 'Explore desert safari packages and activities',
        ],
        'features' => [
            ['name' => 'Camel Rides', 'icon' => 'camel'],
            ['name' => 'Golden Dunes', 'icon' => 'sun-dunes'],
            ['name' => 'Desert Dining', 'icon' => 'utensils'],
        ],
    ],
];

$desertSafarisList = [
    [
        'category' => 'Desert Safaris',
        'title' => 'The Fort - Lisaili Desert Experience',
        'image' => asset('images/desert-camp-experience.png'),
        'bestseller' => true,
        'travellers_choice' => false,
        'location' => 'Dubai',
        'price' => 'PKR 7,618',
        'url' => route('fort-lisaili-desert-experience'),
    ],
    [
        'category' => 'Desert Safaris',
        'title' => 'Evening Desert Safari in Dubai',
        'image' => asset('images/desert-dune-drive.png'),
        'bestseller' => true,
        'travellers_choice' => true,
        'location' => 'Dubai',
        'price' => 'PKR 49,937',
        'url' => 'https://wa.me/971500000000?text=' . urlencode('Hi, I would like to book Evening Desert Safari in Dubai'),
    ],
    [
        'category' => 'Desert Safaris',
        'title' => 'Morning Desert Adventure',
        'image' => asset('images/desert-oasis-morning.png'),
        'bestseller' => true,
        'travellers_choice' => true,
        'location' => 'Dubai',
        'price' => 'PKR 36,856',
        'url' => 'https://wa.me/971500000000?text=' . urlencode('Hi, I would like to book Morning Desert Adventure'),
    ],
    [
        'category' => 'Dune buggies',
        'title' => 'Dune Buggy Adventure in Dubai',
        'image' => asset('images/desert-buggy-adventure.png'),
        'bestseller' => true,
        'travellers_choice' => true,
        'location' => 'Dubai',
        'price' => 'PKR 61,558',
        'url' => 'https://wa.me/971500000000?text=' . urlencode('Hi, I would like to book Dune Buggy Adventure in Dubai'),
    ],
    [
        'category' => 'Desert Experiences',
        'title' => 'Exclusive Desert Experience',
        'image' => asset('images/desert-safari.png'),
        'bestseller' => false,
        'travellers_choice' => true,
        'location' => 'Dubai',
        'price' => 'PKR 230,446',
        'url' => 'https://wa.me/971500000000?text=' . urlencode('Hi, I would like to book the Exclusive Desert Experience'),
    ],
    [
        'category' => 'Desert Experiences',
        'title' => 'Camel Ride in Dubai',
        'image' => asset('images/camel-desert-journey.png'),
        'bestseller' => false,
        'travellers_choice' => false,
        'location' => 'Dubai',
        'price' => 'PKR 38,395',
        'url' => 'https://wa.me/971500000000?text=' . urlencode('Hi, I would like to book a Camel Ride in Dubai'),
    ],
];

$experienceCategories = [
    [
        'title' => 'Desert Safaris',
        'description' => 'Golden dunes, sunset dining and desert stories.',
        'image' => asset('images/desert-camp-experience.png'),
        'url' => '#desert-safaris',
    ],
    [
        'title' => 'Attractions',
        'description' => 'Unmissable Dubai landmarks and family favourites.',
        'image' => asset('images/dubai-attractions.png'),
        'url' => '#attractions',
    ],
    [
        'title' => 'Sports Events',
        'description' => 'The city at full speed, from trackside to stadium.',
        'image' => asset('images/sports-events-dubai.png'),
        'url' => '#sports-events',
    ],
    [
        'title' => 'City Tours',
        'description' => 'Old Dubai, new icons and every view in between.',
        'image' => asset('images/airport-transfer.png'),
        'url' => '#city-tours',
    ],
    [
        'title' => 'Cruise & Boat Tours',
        'description' => 'Sunset horizons and Dubai Marina from the water.',
        'image' => asset('images/cruise-dubai-marina.png'),
        'url' => '#cruise-boat-tours',
    ],
    [
        'title' => 'Water & Theme Parks',
        'description' => 'Big splashes, bright days and family fun.',
        'image' => asset('images/water-theme-parks-dubai.png'),
        'url' => '#waterparks-theme-parks',
    ],
];

$trendingAttractionsList = [
    [
        'category' => 'Desert Safaris',
        'title' => 'Evening Desert Safari in Dubai',
        'image' => asset('images/desert-dune-drive.png'),
        'price' => 'PKR 49,937',
        'badge' => 'Bestseller',
    ],
    [
        'category' => 'Dinner Cruises',
        'title' => 'Lotus Megayacht Shared Dinner Cruise',
        'image' => asset('images/cruise-dubai-marina.png'),
        'price' => 'PKR 23,006',
        'badge' => 'Original',
    ],
    [
        'category' => 'Attractions',
        'title' => 'Helicopter Tour in Dubai',
        'image' => asset('images/helicopter-tour-dubai.png'),
        'price' => 'PKR 54,631',
        'badge' => 'Skyline View',
    ],
    [
        'category' => 'Attractions',
        'title' => 'Global Village Entry Ticket',
        'image' => asset('images/global-village-dubai.png'),
        'price' => 'PKR 2,308',
        'badge' => 'Family Favourite',
    ],
];

$cityTourPromos = [
    [
        'title' => 'Curated City Tours',
        'description' => "Book private and shared tours with expert guides across the country's cultural landmarks.",
        'image' => asset('images/airport-transfer.png'),
        'url' => '#booking',
    ],
    [
        'title' => "UAE's most popular adventures",
        'description' => 'From family fun to bucket-list experiences, there is an adventure for every kind of traveler.',
        'image' => asset('images/cruise-dubai-marina.png'),
        'url' => '#booking',
    ],
];

$topCityToursList = [
    [
        'title' => 'Old Dubai Heritage Walk',
        'image' => asset('images/desert-camp-experience.png'),
        'price' => 'PKR 17,520',
    ],
    [
        'title' => 'Dubai Frame & Downtown Tour',
        'image' => asset('images/airport-transfer.png'),
        'price' => 'PKR 25,161',
    ],
    [
        'title' => 'Dubai Full-Day Discovery Tour',
        'image' => asset('images/helicopter-tour-dubai.png'),
        'price' => 'PKR 18,330',
    ],
    [
        'title' => 'Dubai Marina & JBR Tour',
        'image' => asset('images/cruise-dubai-marina.png'),
        'price' => 'PKR 18,880',
    ],
];

$guestStories = [
    [
        'quote' => 'Every detail felt effortless, from our desert pick-up to the sunset camp. It was the highlight of our Dubai trip.',
        'name' => 'Ayesha & Hamza',
        'meta' => 'Desert safari guests · Lahore',
    ],
    [
        'quote' => 'Our private city tour felt personal, polished and completely stress-free. The team knew exactly what our family would enjoy.',
        'name' => 'Sarah M.',
        'meta' => 'Private city tour guest · London',
    ],
    [
        'quote' => 'Quick replies, a lovely guide and a brilliant family day. We would happily book our next Dubai experience with WMT.',
        'name' => 'Omar R.',
        'meta' => 'Attractions guest · Karachi',
    ],
];

$dubaiMoments = [
    [
        'title' => 'Golden-hour desert',
        'label' => 'Desert escape',
        'image' => asset('images/camel-desert-journey.png'),
        'class' => 'moment-featured',
    ],
    [
        'title' => 'Dunes at sunrise',
        'label' => 'Morning magic',
        'image' => asset('images/desert-oasis-morning.png'),
        'class' => 'moment-tall',
    ],
    [
        'title' => 'Adventure in motion',
        'label' => 'Off-road stories',
        'image' => asset('images/desert-dune-drive.png'),
        'class' => 'moment-regular',
    ],
    [
        'title' => 'Evenings under stars',
        'label' => 'Desert camp',
        'image' => asset('images/desert-camp-experience.png'),
        'class' => 'moment-regular',
    ],
    [
        'title' => 'The city from the water',
        'label' => 'Dubai Marina',
        'image' => asset('images/cruise-dubai-marina.png'),
        'class' => 'moment-wide',
    ],
];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#062d4f">
    <title>Waheed Murad Tourism | Dubai Experiences</title>
    <link rel="preload" as="image" href="{{ asset('images/hero-dubai-aquarium.png') }}" fetchpriority="high">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/site-shell.js'])
</head>
<body class="wmt-site">
    <header class="site-header" id="top">
        <div class="color-ribbon" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span><span></span>
        </div>

        <div class="utility-bar">
            <div class="header-container utility-content">
                <p>Curated journeys across Dubai and the UAE</p>
                <div class="utility-links">
                    <a href="#contact">Travel support</a>
                    <span aria-hidden="true"></span>
                    <a href="#booking">Manage booking</a>
                </div>
            </div>
        </div>

        <div class="main-header">
            <div class="header-container brand-row">
                <a class="brand" href="{{ url('/') }}" aria-label="Waheed Murad Tourism home">
                    <span class="brand-mark">
                        <img src="{{ asset('images/waheed-murad-tourism-logo.jpeg') }}" alt="Waheed Murad Tourism">
                    </span>
                    <span class="brand-copy">
                        <strong>Waheed Murad</strong>
                        <small>Tourism</small>
                    </span>
                </a>

                <div class="desktop-tools">
                    <a class="quick-link" href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer" aria-label="Open WhatsApp chat with local travel expert">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.7a8.4 8.4 0 0 1-12.4 7.4L3.5 20.5l1.5-4.3A8.4 8.4 0 1 1 20.5 11.7Z"/><path d="M8.6 7.9c.2-.5.4-.5.7-.5h.5c.2 0 .4.1.5.4l.8 1.9c.1.2.1.4 0 .6l-.5.7c-.1.2-.1.3 0 .5.5 1 1.3 1.8 2.4 2.3.2.1.4.1.5 0l.8-.9c.2-.2.4-.2.6-.1l1.8.8c.3.1.4.3.4.5 0 .4-.2 1.2-.7 1.5-.3.2-.7.4-1.2.4-.7 0-1.5-.2-2.7-.8a10.3 10.3 0 0 1-4.3-4.1c-.8-1.2-1-2.1-1-2.8 0-.4.2-.8.4-1.1Z"/></svg>
                        <span><small>Talk to a local expert</small><b>WhatsApp us</b></span>
                    </a>
                    <button class="header-search" type="button" aria-label="Search experiences" onclick="document.getElementById('booking')?.scrollIntoView({behavior: 'smooth'})">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.5"/><path d="m16 16 4.4 4.4"/></svg>
                        <span>Search experiences</span>
                    </button>
                    <a class="plan-trip" href="#booking">Plan your trip <span aria-hidden="true">→</span></a>
                </div>

                <div class="mobile-quick-actions" aria-label="Quick actions">
                    <a class="mobile-icon-link" href="#wishlist" aria-label="Wishlist, 0 items">
                        <span class="action-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.8 4.9a5.3 5.3 0 0 0-7.5 0L12 6.2l-1.3-1.3a5.3 5.3 0 0 0-7.5 0L3.2 12.4 12 21l8.8-8.6a5.3 5.3 0 0 0 0-7.5Z"/></svg>
                            <b>0</b>
                        </span>
                    </a>
                    <a class="mobile-icon-link" href="#cart" aria-label="Cart, 0 items">
                        <span class="action-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5.5 8.5h13l-.7 11H6.2l-.7-11Z"/><path d="M9 9V6.5a3 3 0 0 1 6 0V9"/></svg>
                            <b>0</b>
                        </span>
                    </a>
                    <a class="mobile-icon-link whatsapp-mobile" href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer" aria-label="Chat with us on WhatsApp">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.7a8.4 8.4 0 0 1-12.4 7.4L3.5 20.5l1.5-4.3A8.4 8.4 0 1 1 20.5 11.7Z"/><path d="M8.6 7.9c.2-.5.4-.5.7-.5h.5c.2 0 .4.1.5.4l.8 1.9c.1.2.1.4 0 .6l-.5.7c-.1.2-.1.3 0 .5.5 1 1.3 1.8 2.4 2.3.2.1.4.1.5 0l.8-.9c.2-.2.4-.2.6-.1l1.8.8c.3.1.4.3.4.5 0 .4-.2 1.2-.7 1.5-.3.2-.7.4-1.2.4-.7 0-1.5-.2-2.7-.8a10.3 10.3 0 0 1-4.3-4.1c-.8-1.2-1-2.1-1-2.8 0-.4.2-.8.4-1.1Z"/></svg>
                    </a>
                </div>

                <button class="menu-toggle" type="button" aria-controls="mobile-navigation" aria-expanded="false">
                    <span class="sr-only">Open navigation</span>
                    <i></i><i></i><i></i>
                </button>
            </div>
        </div>

        <nav class="primary-navigation" aria-label="Main navigation">
            <div class="header-container navigation-row">
                <div class="nav-links">
                    <div class="nav-item has-mega-menu" data-mega-menu>
                        <button class="nav-trigger" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="desert-adventures-mega-menu">
                            Desert Adventures
                            <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg>
                        </button>
                        <x-site.desert-adventures-mega-menu />
                    </div>
                    <div class="nav-item has-mega-menu" data-attractions-mega-menu>
                        <button class="nav-trigger" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="attractions-mega-menu">
                            Attractions
                            <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg>
                        </button>
                        <x-site.attractions-mega-menu />
                    </div>
                    <a href="{{ route('sports-events') }}">Sports Events</a>
                    <div class="nav-item has-mega-menu" data-city-tours-mega-menu>
                        <button class="nav-trigger" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="city-tours-mega-menu">
                            City Tours
                            <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg>
                        </button>
                        <x-site.city-tours-mega-menu />
                    </div>
                    <a href="{{ route('cruise-boat-tours') }}">Cruise and Boat Tours</a>
                    <a href="{{ route('waterparks-theme-parks') }}">Waterparks &amp; Theme Parks</a>
                    <a href="{{ route('transfers') }}">Transfers</a>
                    <div class="nav-item has-mega-menu" data-why-us-mega-menu>
                        <button class="nav-trigger" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="why-us-mega-menu">
                            Why us
                            <svg viewBox="0 0 16 16" aria-hidden="true"><path d="m4 6 4 4 4-4"/></svg>
                        </button>
                        <x-site.why-us-mega-menu />
                    </div>
                </div>

                <div class="account-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="account-link">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 21a7.5 7.5 0 0 1 15 0"/></svg>
                            <span>My account</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="account-link">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 21a7.5 7.5 0 0 1 15 0"/></svg>
                            <span>Sign in</span>
                        </a>
                    @endauth
                    <a class="header-action" href="#wishlist" aria-label="Wishlist, 0 items">
                        <span class="action-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.8 4.9a5.3 5.3 0 0 0-7.5 0L12 6.2l-1.3-1.3a5.3 5.3 0 0 0-7.5 7.5L12 21l8.8-8.6a5.3 5.3 0 0 0 0-7.5Z"/></svg>
                            <b>0</b>
                        </span>
                        <span>Wishlist</span>
                    </a>
                    <a class="header-action" href="#cart" aria-label="Cart, 0 items">
                        <span class="action-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5.5 8.5h13l-.7 11H6.2l-.7-11Z"/><path d="M9 9V6.5a3 3 0 0 1 6 0V9"/></svg>
                            <b>0</b>
                        </span>
                        <span>Cart</span>
                    </a>
                </div>
            </div>
        </nav>

        <div class="mobile-navigation" id="mobile-navigation" hidden aria-hidden="true">
            <button class="mobile-menu-scrim" type="button" aria-label="Close navigation"></button>
            <aside class="mobile-menu-drawer" aria-label="Mobile navigation">
                <div class="mobile-menu-bar">
                    <span>Explore Dubai</span>
                    <button class="mobile-menu-close" type="button" aria-label="Close navigation">×</button>
                </div>

                <nav class="mobile-menu-main" aria-label="Mobile main navigation">
                    <button class="mobile-menu-item mobile-menu-trigger" type="button" aria-controls="mobile-desert-menu" aria-expanded="false">
                        <span class="mobile-nav-icon icon-dunes" aria-hidden="true">⌁</span>
                        <span>Desert Adventures</span><i aria-hidden="true">›</i>
                    </button>
                    <a class="mobile-menu-item" href="#attractions"><span class="mobile-nav-icon icon-attractions" aria-hidden="true">✦</span><span>Attractions</span><i aria-hidden="true">›</i></a>
                    <a class="mobile-menu-item" href="{{ route('sports-events') }}"><span class="mobile-nav-icon icon-sports" aria-hidden="true">◉</span><span>Sports Events</span><i aria-hidden="true">›</i></a>
                    <a class="mobile-menu-item" href="#city-tours"><span class="mobile-nav-icon icon-city" aria-hidden="true">▥</span><span>City Tours</span><i aria-hidden="true">›</i></a>
                    <a class="mobile-menu-item" href="{{ route('cruise-boat-tours') }}"><span class="mobile-nav-icon icon-cruise" aria-hidden="true">⌇</span><span>Cruise and Boat Tours</span><i aria-hidden="true">›</i></a>
                    <a class="mobile-menu-item" href="{{ route('waterparks-theme-parks') }}"><span class="mobile-nav-icon icon-parks" aria-hidden="true">♧</span><span>Waterparks &amp; Theme Parks</span><i aria-hidden="true">›</i></a>
                    <a class="mobile-menu-item" href="{{ route('transfers') }}"><span class="mobile-nav-icon icon-transfers" aria-hidden="true">↗</span><span>Transfers</span><i aria-hidden="true">›</i></a>
                    <a class="mobile-menu-item" href="#why-us"><span class="mobile-nav-icon icon-why" aria-hidden="true">♥</span><span>Why us</span><i aria-hidden="true">›</i></a>
                </nav>

                <div class="mobile-menu-actions">
                    @auth
                        <a href="{{ url('/dashboard') }}">My account</a>
                    @else
                        <a href="{{ route('login') }}">Sign in / Create account</a>
                    @endauth
                    <a class="mobile-plan-trip" href="#booking">Plan your trip <span aria-hidden="true">→</span></a>
                </div>

                <x-site.desert-adventures-mega-menu mobile />
            </aside>
        </div>
    </header>

    <main class="site-canvas" aria-label="Waheed Murad Tourism">
        <!-- ==========================================
             HERO SLIDER SECTION (4-Slide Carousel)
             ========================================== -->
        <div class="hero-slider-wrapper">
            <div class="header-container">
                <section
                    class="hero-slider-section"
                    x-data="heroSlider({{ count($heroSlides) }}, 3000)"
                    x-init="init()"
                    @mouseenter="pause()"
                    @mouseleave="resume()"
                    @focusin="pause()"
                    @focusout="resume()"
                    @touchstart="handleTouchStart($event)"
                    @touchmove="handleTouchMove($event)"
                    @touchend="handleTouchEnd()"
                    @keydown="handleKeydown($event)"
                    tabindex="0"
                    role="region"
                    aria-roledescription="carousel"
                    aria-label="Dubai Experiences and Tours Hero Slider"
                >
                    <div class="hero-slides-track">
                        @foreach($heroSlides as $index => $slide)
                            <article
                                class="hero-slide"
                                :class="{ 'is-active': activeSlide === {{ $index }} }"
                                :aria-hidden="activeSlide !== {{ $index }}"
                                role="group"
                                aria-roledescription="slide"
                                aria-label="Slide {{ $index + 1 }} of {{ count($heroSlides) }}: {{ $slide['heading'] }}"
                            >
                                <!-- Slider Background Image (Pure Image Background) -->
                                <img
                                    src="{{ $slide['image'] }}"
                                    alt="{{ $slide['image_alt'] }}"
                                    class="hero-slide-bg"
                                    @if($index === 0)
                                        loading="eager"
                                        fetchpriority="high"
                                    @else
                                        loading="lazy"
                                    @endif
                                >

                                <!-- Subtle Dark Gradient Overlay for Readability -->
                                <div class="hero-slide-overlay" aria-hidden="true"></div>

                                <!-- Slide Foreground Content (HTML / CSS Rendered) -->
                                <div class="hero-slide-inner">
                                    <div class="hero-slide-content">
                                        <!-- Small Badge -->
                                        <div class="hero-badge">
                                            <span class="hero-badge-dot" aria-hidden="true"></span>
                                            <span>{{ $slide['badge'] }}</span>
                                        </div>

                                        <!-- Main Heading with Golden Highlight -->
                                        <h1 class="hero-heading">
                                            @php
                                                $highlight = $slide['heading_highlight'];
                                                $heading = e($slide['heading']);
                                                $highlightEscaped = e($highlight);
                                                $formattedHeading = str_replace(
                                                    $highlightEscaped,
                                                    '<span class="hero-gold-text">' . $highlightEscaped . '</span>',
                                                    $heading
                                                );
                                            @endphp
                                            {!! $formattedHeading !!}
                                        </h1>

                                        <!-- Description -->
                                        <p class="hero-desc">{{ $slide['description'] }}</p>

                                        <!-- Real Interactive Booking & Tour Buttons -->
                                        <div class="hero-actions">
                                            <a
                                                href="{{ $slide['primary_btn']['url'] }}"
                                                class="hero-btn-primary"
                                                aria-label="{{ $slide['primary_btn']['aria_label'] }}"
                                            >
                                                <span>{{ $slide['primary_btn']['text'] }}</span>
                                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                                                    <path d="M4 10h12" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="m11 5 5 5-5 5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>

                                            <a
                                                href="{{ $slide['secondary_btn']['url'] }}"
                                                class="hero-btn-secondary"
                                                aria-label="{{ $slide['secondary_btn']['aria_label'] }}"
                                            >
                                                <span>{{ $slide['secondary_btn']['text'] }}</span>
                                                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                                                    <path d="m7 4 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </div>

                                        <!-- Key Feature Icons & Labels -->
                                        <div class="hero-features" aria-label="Features of {{ $slide['heading'] }}">
                                            @foreach($slide['features'] as $feature)
                                                <div class="hero-feature-pill">
                                                    <span class="hero-feature-icon" aria-hidden="true">
                                                        <x-hero-icon :icon="$feature['icon']" />
                                                    </span>
                                                    <span>{{ $feature['name'] }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Previous Navigation Arrow -->
                    <button
                        type="button"
                        class="hero-arrow hero-arrow-prev"
                        @click="prev()"
                        aria-label="Previous slide"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m15 18-6-6 6-6"/>
                        </svg>
                    </button>

                    <!-- Next Navigation Arrow -->
                    <button
                        type="button"
                        class="hero-arrow hero-arrow-next"
                        @click="next()"
                        aria-label="Next slide"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </button>

                    <!-- Clickable Pagination Dots -->
                    <div class="hero-pagination" role="tablist" aria-label="Slider Pagination">
                        @foreach($heroSlides as $i => $s)
                            <button
                                type="button"
                                class="hero-dot"
                                :class="{ 'is-active': activeSlide === {{ $i }} }"
                                @click="goTo({{ $i }})"
                                role="tab"
                                :aria-selected="activeSlide === {{ $i }}"
                                aria-label="Go to slide {{ $i + 1 }}: {{ $s['badge'] }}"
                            ></button>
                        @endforeach
                    </div>

                    <!-- Slide Counter Badge -->
                    <div class="hero-counter" aria-hidden="true">
                        <span class="hero-counter-current" x-text="String(activeSlide + 1).padStart(2, '0')">01</span>
                        <span class="hero-counter-divider">/</span>
                        <span class="hero-counter-total">{{ sprintf('%02d', count($heroSlides)) }}</span>
                    </div>
                </section>
            </div>
        </div>

        <section class="travel-assurance-section" aria-label="Travel with confidence">
            <div class="header-container">
                <div class="travel-assurance-shell">
                    <div class="travel-assurance-item">
                        <span class="travel-assurance-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2 4.5 5v5.5c0 4.8 3 8.9 7.5 10.5 4.5-1.6 7.5-5.7 7.5-10.5V5L12 2Z"/><path d="m8.5 11.5 2.2 2.2 4.8-4.8"/></svg></span>
                        <span><strong>Trusted local team</strong><small>Expertly planned Dubai days</small></span>
                    </div>
                    <div class="travel-assurance-item">
                        <span class="travel-assurance-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 12a8 8 0 1 1-2.34-5.66"/><path d="M20 4v5h-5"/></svg></span>
                        <span><strong>Plans that stay flexible</strong><small>Easy support when plans change</small></span>
                    </div>
                    <div class="travel-assurance-item">
                        <span class="travel-assurance-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 17.5 3.5 21l.8-5.1A8.5 8.5 0 1 1 12 20.5c-1.2 0-2.35-.25-3.35-.7Z"/><path d="M8 12h.01M12 12h.01M16 12h.01" stroke-linecap="round" stroke-width="2.5"/></svg></span>
                        <span><strong>Here when you need us</strong><small>Quick WhatsApp assistance</small></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             DESERT SAFARIS IN DUBAI SECTION (Screenshot Match)
             ========================================== -->
        <span id="booking" style="scroll-margin-top: 80px;"></span>
        <section
            class="safaris-section"
            id="desert-safaris"
            x-data="{
                autoSlide: null,
                init() {
                    this.resume();
                },
                pause() {
                    if (this.autoSlide) {
                        clearInterval(this.autoSlide);
                        this.autoSlide = null;
                    }
                },
                resume() {
                    this.pause();
                    this.autoSlide = setInterval(() => this.scrollRight(), 4000);
                },
                scrollLeft() {
                    const track = this.$refs.safarisTrack;
                    if (track) {
                        const amount = track.firstElementChild ? track.firstElementChild.offsetWidth + 20 : 300;
                        const atBeginning = track.scrollLeft <= 8;
                        track.scrollTo({ left: atBeginning ? track.scrollWidth : track.scrollLeft - amount, behavior: 'smooth' });
                    }
                },
                scrollRight() {
                    const track = this.$refs.safarisTrack;
                    if (track) {
                        const amount = track.firstElementChild ? track.firstElementChild.offsetWidth + 20 : 300;
                        const atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 8;
                        track.scrollTo({ left: atEnd ? 0 : track.scrollLeft + amount, behavior: 'smooth' });
                    }
                }
            }"
        >
            <div class="header-container">
                <!-- Header with Title and Nav Arrows -->
                <div class="safaris-header">
                    <h2 class="safaris-title">
                        <span>Desert</span>
                        <span class="safaris-pill-word">Safaris</span>
                        <span>in Dubai</span>
                    </h2>

                    <div class="safaris-nav-arrows">
                        <button
                            type="button"
                            class="safaris-arrow-btn"
                            @click="scrollLeft()"
                            aria-label="Previous safaris"
                        >
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6"/>
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="safaris-arrow-btn"
                            @click="scrollRight()"
                            aria-label="Next safaris"
                        >
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Cards Track -->
                <div class="safaris-track-wrapper" @mouseenter="pause()" @mouseleave="resume()" @touchstart.passive="pause()">
                    <div class="safaris-track" x-ref="safarisTrack">
                        @foreach($desertSafarisList as $safari)
                            <article class="safari-card">
                                <div class="safari-card-media">
                                    <img
                                        src="{{ $safari['image'] }}"
                                        alt="{{ $safari['title'] }}"
                                        loading="lazy"
                                    >
                                </div>
                                <div class="safari-card-body">
                                    <span class="safari-card-category">{{ $safari['category'] }}</span>
                                    <h3 class="safari-card-title"><a href="{{ $safari['url'] }}">{{ $safari['title'] }}</a></h3>

                                    <div class="safari-card-badges">
                                        @if($safari['bestseller'])
                                            <span class="badge-bestseller">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" aria-hidden="true"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                                                <span>Bestseller</span>
                                            </span>
                                        @endif

                                        @if($safari['travellers_choice'])
                                            <span class="badge-travellers-choice">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                                                <span>2025 Travellers' Choice</span>
                                            </span>
                                        @endif

                                        @if($safari['location'])
                                            <span class="badge-location">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                                <span>{{ $safari['location'] }}</span>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="safari-card-price">
                                        <span>From</span>
                                        <strong>{{ $safari['price'] }}</strong>
                                    </div>

                                    <a
                                        href="{{ $safari['url'] }}"
                                        @if (str_starts_with($safari['url'], 'http'))
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        @endif
                                        class="safari-card-btn"
                                        aria-label="Book {{ $safari['title'] }}"
                                    >
                                        Book now
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <!-- Footer View All Action -->
                <div class="safaris-footer-action">
                    <a href="#desert-adventures" class="view-all-safaris-btn">
                        <span>View all Desert Safaris</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Signature experiences (replaces the former airport transfer cards) -->
        <section class="experiences-showcase" id="experiences" aria-labelledby="experiences-heading">
            <span id="transfers" class="section-anchor" aria-hidden="true"></span>
            <div class="header-container">
                <div class="experiences-showcase-heading">
                    <div>
                        <span class="section-tag">CHOOSE YOUR DUBAI</span>
                        <h2 id="experiences-heading">Our <span>experiences</span></h2>
                    </div>
                    <p>From desert horizons to world-famous attractions, find the Dubai experience made for you.</p>
                </div>

                <div class="experiences-category-grid">
                    @foreach($experienceCategories as $experience)
                        <a class="experience-category-card" href="{{ $experience['url'] }}">
                            <span class="experience-category-image-wrap">
                                <img src="{{ $experience['image'] }}" alt="{{ $experience['title'] }} in Dubai" loading="lazy">
                                <span class="experience-category-overlay"></span>
                            </span>
                            <span class="experience-category-copy">
                                <b>{{ $experience['title'] }}</b>
                                <small>{{ $experience['description'] }}</small>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Trending attractions (#attractions) -->
        <section
            class="trending-attractions-section"
            id="attractions"
            x-data="{
                scrollLeft() {
                    const track = this.$refs.trendingTrack;
                    if (track) {
                        const amount = track.firstElementChild ? track.firstElementChild.offsetWidth + 20 : 300;
                        track.scrollBy({ left: -amount, behavior: 'smooth' });
                    }
                },
                scrollRight() {
                    const track = this.$refs.trendingTrack;
                    if (track) {
                        const amount = track.firstElementChild ? track.firstElementChild.offsetWidth + 20 : 300;
                        track.scrollBy({ left: amount, behavior: 'smooth' });
                    }
                }
            }"
        >
            <div class="trending-attractions-pattern" aria-hidden="true"></div>
            <div class="header-container">
                <div class="trending-attractions-header">
                    <div>
                        <span class="section-tag">EXPLORE DUBAI</span>
                        <h2>Trending <span>attractions</span></h2>
                        <p>There is no place quite like Dubai.</p>
                    </div>
                    <div class="trending-attractions-arrows" aria-label="Trending attractions navigation">
                        <button type="button" @click="scrollLeft()" aria-label="Previous trending attractions">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <button type="button" @click="scrollRight()" aria-label="Next trending attractions">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    </div>
                </div>

                <div class="trending-attractions-track" x-ref="trendingTrack">
                    @foreach($trendingAttractionsList as $attraction)
                        <article class="trending-attraction-card">
                            <div class="trending-attraction-media">
                                <img src="{{ $attraction['image'] }}" alt="{{ $attraction['title'] }}" loading="lazy">
                                <span>{{ $attraction['badge'] }}</span>
                            </div>
                            <div class="trending-attraction-body">
                                <p>{{ $attraction['category'] }}</p>
                                <h3>{{ $attraction['title'] }}</h3>
                                <span class="trending-attraction-location"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 11-8 11S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>Dubai</span>
                                <div class="trending-attraction-footer">
                                    <span>From <b>{{ $attraction['price'] }}</b></span>
                                    <a href="#booking">Book now <span aria-hidden="true">→</span></a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <a class="trending-view-more" href="#booking">Explore all attractions <span aria-hidden="true">→</span></a>
            </div>
        </section>

        <!-- City tours collection (#city-tours) -->
        <section
            class="city-tours-collection"
            id="city-tours"
            x-data="{
                scrollLeft() {
                    const track = this.$refs.cityToursTrack;
                    if (track) {
                        const amount = track.firstElementChild ? track.firstElementChild.offsetWidth + 20 : 300;
                        track.scrollBy({ left: -amount, behavior: 'smooth' });
                    }
                },
                scrollRight() {
                    const track = this.$refs.cityToursTrack;
                    if (track) {
                        const amount = track.firstElementChild ? track.firstElementChild.offsetWidth + 20 : 300;
                        track.scrollBy({ left: amount, behavior: 'smooth' });
                    }
                }
            }"
        >
            <div class="city-tours-glow city-tours-glow-one" aria-hidden="true"></div>
            <div class="city-tours-glow city-tours-glow-two" aria-hidden="true"></div>
            <div class="header-container">
                <div class="city-tours-promo-grid">
                    @foreach($cityTourPromos as $promo)
                        <article class="city-tour-promo-card">
                            <img src="{{ $promo['image'] }}" alt="{{ $promo['title'] }}" loading="lazy">
                            <div class="city-tour-promo-shade"></div>
                            <div class="city-tour-promo-copy">
                                <span>WMT CURATED</span>
                                <h2>{{ $promo['title'] }}</h2>
                                <p>{{ $promo['description'] }}</p>
                                <a href="{{ $promo['url'] }}">Learn more <span aria-hidden="true">→</span></a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="top-city-tours-header">
                    <div>
                        <span class="section-tag">CITY DISCOVERY</span>
                        <h2>Top City <span>Tours</span></h2>
                        <p>See the UAE through stories, skyline views and local moments.</p>
                    </div>
                    <div class="top-city-tours-arrows" aria-label="Top city tours navigation">
                        <button type="button" @click="scrollLeft()" aria-label="Previous city tours"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg></button>
                        <button type="button" @click="scrollRight()" aria-label="Next city tours"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></button>
                    </div>
                </div>

                <div class="top-city-tours-track" x-ref="cityToursTrack">
                    @foreach($topCityToursList as $tour)
                        <article class="top-city-tour-card">
                            <div class="top-city-tour-media">
                                <img src="{{ $tour['image'] }}" alt="{{ $tour['title'] }}" loading="lazy">
                                <span>City Tour</span>
                            </div>
                            <div class="top-city-tour-body">
                                <h3>{{ $tour['title'] }}</h3>
                                <span class="top-city-tour-location"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 11-8 11S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>Dubai, UAE</span>
                                <div class="top-city-tour-footer">
                                    <span>From <b>{{ $tour['price'] }}</b></span>
                                    <a href="#booking">Book now</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <a class="top-city-tours-view-all" href="#booking">View all City Tours <span aria-hidden="true">→</span></a>
            </div>
        </section>

        <!-- Signature Journeys & Guest Stories (#why-us) -->
        <section class="signature-journeys-section" id="why-us">
            <div class="header-container">
                <div class="signature-journey-shell">
                    <div class="signature-journey-visual">
                        <img src="{{ asset('images/camel-desert-journey.png') }}" alt="Travelers riding camels through Dubai desert dunes at sunrise" loading="lazy">
                        <span class="signature-journey-badge">WMT SELECT</span>
                        <span class="signature-journey-caption">Dubai, beyond the ordinary</span>
                    </div>

                    <div class="signature-journey-copy">
                        <span class="signature-journey-eyebrow">DESIGNED FOR THE WAY YOU TRAVEL</span>
                        <h2>More than a booking.<br><em>A Dubai memory.</em></h2>
                        <p>From a sunrise across the dunes to a city evening made just for you, our local team turns simple plans into standout moments.</p>

                        <ul class="signature-journey-points">
                            <li><span aria-hidden="true">✦</span> Local experts, thoughtful details</li>
                            <li><span aria-hidden="true">✦</span> Flexible plans for every pace</li>
                            <li><span aria-hidden="true">✦</span> Support from first message to last stop</li>
                        </ul>

                        <a class="signature-journey-cta" href="#booking">Plan your experience <span aria-hidden="true">→</span></a>
                    </div>
                </div>

                <section class="guest-stories-section" aria-labelledby="guest-stories-title" x-data="{ active: 0, total: {{ count($guestStories) }}, next() { this.active = (this.active + 1) % this.total }, previous() { this.active = (this.active - 1 + this.total) % this.total } }">
                    <div class="guest-stories-intro">
                        <span class="guest-stories-eyebrow">GUEST STORIES</span>
                        <h2 id="guest-stories-title">Loved in every<br>little detail.</h2>
                        <div class="guest-stories-rating" aria-label="Five star guest experience">
                            <span aria-hidden="true">★★★★★</span>
                            <strong>Made for memorable days</strong>
                        </div>
                        <p>Real moments from travellers who explored Dubai with Waheed Murad Tourism.</p>
                    </div>

                    <div class="guest-stories-slider" aria-live="polite">
                        <button class="guest-story-arrow guest-story-previous" type="button" @click="previous()" aria-label="Previous guest story"><span aria-hidden="true">←</span></button>
                        <div class="guest-story-window">
                            @foreach($guestStories as $index => $story)
                                <article class="guest-story-card" x-show="active === {{ $index }}" x-cloak>
                                    <span class="guest-story-quote" aria-hidden="true">“</span>
                                    <blockquote>{{ $story['quote'] }}</blockquote>
                                    <footer>
                                        <strong>{{ $story['name'] }}</strong>
                                        <span>{{ $story['meta'] }}</span>
                                    </footer>
                                </article>
                            @endforeach
                        </div>
                        <button class="guest-story-arrow guest-story-next" type="button" @click="next()" aria-label="Next guest story"><span aria-hidden="true">→</span></button>

                        <div class="guest-story-dots" role="tablist" aria-label="Guest stories">
                            @foreach($guestStories as $index => $story)
                                <button type="button" :class="{ 'is-active': active === {{ $index }} }" @click="active = {{ $index }}" aria-label="Show story {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </section>

        <section class="moments-section" id="moments" aria-labelledby="moments-title">
            <div class="header-container">
                <div class="moments-heading">
                    <div>
                        <span class="moments-eyebrow">TRAVEL, REMEMBERED</span>
                        <h2 id="moments-title"><span class="moments-title-your">Your</span> <span class="moments-title-dubai">Dubai</span> <em>Moments</em></h2>
                    </div>
                    <p>Small scenes, big stories — a glimpse of the experiences waiting for you across Dubai and the UAE.</p>
                </div>

                <div class="moments-gallery">
                    @foreach($dubaiMoments as $index => $moment)
                        <a class="moment-card {{ $moment['class'] }}" href="#booking" aria-label="Explore {{ $moment['title'] }}">
                            <img src="{{ $moment['image'] }}" alt="{{ $moment['title'] }}" loading="lazy">
                            <span class="moment-card-shade" aria-hidden="true"></span>
                            <span class="moment-number">0{{ $index + 1 }}</span>
                            <span class="moment-card-content">
                                <small>{{ $moment['label'] }}</small>
                                <strong>{{ $moment['title'] }}</strong>
                                <span>Explore <b aria-hidden="true">↗</b></span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <a class="floating-whatsapp" href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer" aria-label="Chat with Waheed Murad Tourism on WhatsApp">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20.4 11.5a8.25 8.25 0 0 1-12.17 7.28L4 20l1.28-4.02A8.25 8.25 0 1 1 20.4 11.5Z"/><path d="M8.7 8.3c.22-.5.43-.52.65-.53h.55c.17 0 .37.07.44.34l.55 1.52c.08.22.04.45-.1.62l-.43.5c-.13.15-.08.3.02.44.3.51.79 1.12 1.7 1.55.15.07.26.06.36-.05l.56-.66c.14-.17.34-.2.54-.13l1.46.69c.23.11.3.25.27.47-.07.65-.42 1.19-.95 1.48-.3.16-.67.26-1.13.16-1.26-.28-2.9-1.31-4.02-2.6-1.13-1.3-1.73-2.82-1.62-3.82.05-.45.2-.84.38-1.13Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span>Chat on WhatsApp</span>
    </a>

    <!-- ==========================================
         SITE FOOTER (#contact)
         ========================================== -->
    <footer class="site-footer" id="contact">
        <div class="footer-ribbon" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
        </div>
        <div class="header-container footer-top">
            <div class="footer-grid">
                <div class="footer-brand-column">
                    <a class="footer-brand" href="{{ url('/') }}" aria-label="Waheed Murad Tourism home">
                        <img src="{{ asset('images/waheed-murad-tourism-logo.jpeg') }}" alt="Waheed Murad Tourism">
                        <span><strong>Waheed Murad</strong><small>Tourism</small></span>
                    </a>
                    <p class="footer-subscribe-copy">Get Dubai ideas, seasonal offers and travel inspiration in your inbox.</p>
                    <a class="footer-subscribe-button" href="#booking">Get travel updates <span aria-hidden="true">→</span></a>
                    <div class="footer-socials" aria-label="Social media links">
                        <a href="#contact" aria-label="Instagram">ig</a>
                        <a href="#contact" aria-label="Facebook">f</a>
                        <a href="#contact" aria-label="Trip advisor">ta</a>
                        <a href="#contact" aria-label="LinkedIn">in</a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Contact us</h4>
                    <ul class="footer-contact-list">
                        <li><span aria-hidden="true">☎</span><a href="tel:+971500000000">+971 50 000 0000</a></li>
                        <li><span aria-hidden="true">◉</span><a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">WhatsApp our travel desk</a></li>
                        <li><span aria-hidden="true">✉</span><a href="mailto:hello@waheedmuradtourism.com">hello@waheedmuradtourism.com</a></li>
                        <li><span aria-hidden="true">⌖</span><a href="#contact">Downtown Dubai, UAE</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Explore Dubai</h4>
                    <ul class="footer-links">
                        <li><a href="#desert-safaris">Desert Safaris</a></li>
                        <li><a href="#attractions">Attractions</a></li>
                        <li><a href="#city-tours">City Tours</a></li>
                        <li><a href="#cruise-boat-tours">Cruise &amp; Boat Tours</a></li>
                        <li><a href="#waterparks-theme-parks">Water &amp; Theme Parks</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Waheed Murad Tourism</h4>
                    <ul class="footer-links">
                        <li><a href="#why-us">About us</a></li>
                        <li><a href="#why-us">Why Choose Us</a></li>
                        <li><a href="#contact">Partner with us</a></li>
                        <li><a href="#booking">Plan your trip</a></li>
                        <li><a href="#contact">Travel support</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Travel information</h4>
                    <ul class="footer-links">
                        <li><a href="#contact">Booking guidelines</a></li>
                        <li><a href="#contact">Cancellation policy</a></li>
                        <li><a href="#contact">Terms &amp; conditions</a></li>
                        <li><a href="#contact">Privacy policy</a></li>
                        <li><a href="#contact">Frequently asked questions</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="header-container footer-bottom">
            <div class="footer-meta-selects"><span>English ▾</span><span>PKR ▾</span></div>
            <span>&copy; {{ date('Y') }} Waheed Murad Tourism. All rights reserved.</span>
            <span>Dubai, United Arab Emirates</span>
        </div>
    </footer>

</body>
</html>
