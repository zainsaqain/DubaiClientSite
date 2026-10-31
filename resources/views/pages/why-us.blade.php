@extends('layouts.desert-adventures')

@section('title', 'Why Choose Us | Waheed Murad Tourism')

@section('content')
    <div class="why-us-page">
        <div class="why-us-container">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Why Choose Us']]" />

            <header class="why-us-header">
                <span class="why-us-kicker">WHY WAHEED MURAD TOURISM</span>
                <h1 class="why-us-main-title">
                    <span>Why</span>
                    <span class="why-us-pill-badge">Choose</span>
                    <span>Us</span>
                </h1>
                <p>Thoughtful Dubai experiences, planned by people who know every detail.</p>
            </header>

            <section class="why-us-hero-banner" aria-label="Dubai desert experience">
                <div class="why-us-hero-card">
                    <img src="{{ asset('images/desert-safari.png') }}" alt="Guests enjoying a golden Dubai desert safari" class="why-us-hero-image" fetchpriority="high">
                    <div class="why-us-hero-overlay"></div>
                    <div class="why-us-partner-stamp" aria-label="Waheed Murad Tourism local expertise">
                        <span>WMT</span>
                        <strong>LOCAL EXPERTS</strong>
                        <small>Dubai, personally curated</small>
                    </div>
                </div>
            </section>

            <section class="why-us-ethos-card" aria-labelledby="ethos-title">
                <span class="why-us-kicker">THE WMT STANDARD</span>
                <h2 id="ethos-title" class="why-us-section-title">Ethos of <em>Excellence</em></h2>
                <p class="why-us-ethos-lead">Every itinerary is shaped around comfort, care and the kind of local insight that turns a booking into a memory. From your first WhatsApp message to the final drop-off, our team makes Dubai feel effortless.</p>
                <div class="why-us-trust-grid">
                    <article><b>✓</b><span><strong>Licensed operators</strong><small>Experienced local guides and trusted partners.</small></span></article>
                    <article><b>24/7</b><span><strong>Here when you need us</strong><small>Fast support before, during and after your tour.</small></span></article>
                    <article><b>✦</b><span><strong>Flexible experiences</strong><small>Plans that work for couples, families and groups.</small></span></article>
                </div>
            </section>

            <section class="why-us-features-list" aria-label="Reasons to choose Waheed Murad Tourism">
                <article class="why-us-feature-row">
                    <div class="why-us-feature-media"><img src="{{ asset('images/desert-camp-experience.png') }}" alt="A welcoming evening camp in the Dubai desert" loading="lazy"></div>
                    <div class="why-us-feature-copy">
                        <span>ONE JOURNEY, MANY SIDES OF DUBAI</span>
                        <h3>Desert Nights to City Lights</h3>
                        <p>Spend the afternoon crossing golden dunes, then make the most of Dubai's celebrated landmarks, waterfronts and family attractions. We connect the desert, the city and every little detail in between through one friendly local team.</p>
                        <a href="{{ route('desert-adventures') }}">Explore desert adventures <i>→</i></a>
                    </div>
                </article>

                <article class="why-us-feature-row why-us-feature-row-reverse">
                    <div class="why-us-feature-media"><img src="{{ asset('images/dubai-adventure.png') }}" alt="A memorable Dubai adventure with iconic city views" loading="lazy"></div>
                    <div class="why-us-feature-copy">
                        <span>MADE FOR YOUR WISHLIST</span>
                        <h3>Bucket List Moments</h3>
                        <p>Whether your must-do moment is a desert sunset, a marine escape or an iconic attraction, we help you experience it your way. Our curated choices make it easy to choose more of what you love and less of what you need to organise.</p>
                        <a href="{{ route('attractions') }}">Browse attractions <i>→</i></a>
                    </div>
                </article>

                <article class="why-us-feature-row">
                    <div class="why-us-feature-media"><img src="{{ asset('images/desert-oasis-morning.png') }}" alt="A peaceful morning in Dubai's natural desert landscape" loading="lazy"></div>
                    <div class="why-us-feature-copy">
                        <span>TRAVEL WITH CARE</span>
                        <h3>Nature First</h3>
                        <p>Dubai's desert is remarkable, and it deserves to stay that way. We select responsible experiences and work with guides who respect the land, wildlife and communities that make every journey feel authentic.</p>
                        <a href="{{ route('city-tours') }}">Discover city tours <i>→</i></a>
                    </div>
                </article>
            </section>

            <section class="why-us-cta" aria-label="Plan your trip">
                <div><span>READY WHEN YOU ARE</span><h2>Let's make your Dubai story unforgettable.</h2></div>
                <a href="{{ route('home') }}#plan-your-trip">Plan your trip <i>→</i></a>
            </section>
        </div>
    </div>
@endsection
