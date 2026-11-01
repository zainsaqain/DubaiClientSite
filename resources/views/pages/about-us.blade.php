@extends('layouts.desert-adventures')

@section('title', 'About Us | Waheed Murad Tourism')

@section('content')
    <div class="why-us-page">
        <div class="why-us-container">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'About Us']]" />

            <header class="why-us-header">
                <span class="why-us-kicker">ABOUT WAHEED MURAD TOURISM</span>
                <h1 class="why-us-main-title">
                    <span>Made for</span>
                    <span class="why-us-pill-badge">Dubai</span>
                    <span>memories</span>
                </h1>
                <p>Locally curated experiences, warm hospitality and thoughtful details from a team that knows Dubai.</p>
            </header>

            <section class="why-us-hero-banner" aria-label="Dubai desert experience">
                <div class="why-us-hero-card">
                    <img src="{{ asset('images/why-us/why-us-hero.jpg') }}" alt="Guests exploring the golden dunes of Dubai" class="why-us-hero-image" fetchpriority="high">
                    <div class="why-us-hero-overlay"></div>
                    <div class="why-us-partner-stamp" aria-label="Waheed Murad Tourism local expertise">
                        <span>WMT</span>
                        <strong>LOCAL EXPERTS</strong>
                        <small>Dubai, personally curated</small>
                    </div>
                </div>
            </section>

            <section class="why-us-ethos-card" aria-labelledby="about-ethos-title">
                <span class="why-us-kicker">OUR STORY</span>
                <h2 id="about-ethos-title" class="why-us-section-title">Hospitality with <em>Heart</em></h2>
                <p class="why-us-ethos-lead">Waheed Murad Tourism was built around a simple belief: every visitor deserves to experience Dubai with confidence, comfort and genuine care. We bring together trusted local partners, clear planning and personal support to make each moment feel easy.</p>
                <div class="why-us-trust-grid">
                    <article><b>✓</b><span><strong>Trusted local team</strong><small>Helpful advice from people who know Dubai first-hand.</small></span></article>
                    <article><b>24/7</b><span><strong>Always close by</strong><small>Responsive support whenever your plans need a hand.</small></span></article>
                    <article><b>✦</b><span><strong>Made around you</strong><small>Experiences for couples, families, friends and groups.</small></span></article>
                </div>
            </section>

            <section class="why-us-features-list" aria-label="Discover Waheed Murad Tourism">
                <article class="why-us-feature-row">
                    <div class="why-us-feature-media"><img src="{{ asset('images/why-us/desert-nights.jpg') }}" alt="A welcoming desert camp at sunset" loading="lazy"></div>
                    <div class="why-us-feature-copy">
                        <span>AUTHENTIC EXPERIENCES</span>
                        <h3>Desert Nights to City Lights</h3>
                        <p>From the stillness of a desert sunset to the energy of Dubai's waterfronts, we connect the places that make this city extraordinary. Every experience is selected for its quality, character and memorable local touch.</p>
                        <a href="{{ route('desert-adventures') }}">Explore desert adventures <i>→</i></a>
                    </div>
                </article>

                <article class="why-us-feature-row why-us-feature-row-reverse">
                    <div class="why-us-feature-media"><img src="{{ asset('images/why-us/bucket-list.jpg') }}" alt="Guests enjoying an iconic Dubai adventure" loading="lazy"></div>
                    <div class="why-us-feature-copy">
                        <span>YOUR TIME, WELL SPENT</span>
                        <h3>Bucket List Moments</h3>
                        <p>Whether you are travelling for thrilling views, family laughter or a once-in-a-lifetime celebration, our curated collection helps you spend less time planning and more time enjoying the journey.</p>
                        <a href="{{ route('attractions') }}">Browse attractions <i>→</i></a>
                    </div>
                </article>

                <article class="why-us-feature-row">
                    <div class="why-us-feature-media"><img src="{{ asset('images/why-us/nature-first.jpg') }}" alt="Wildlife in Dubai's desert landscape" loading="lazy"></div>
                    <div class="why-us-feature-copy">
                        <span>TRAVEL WITH CARE</span>
                        <h3>Nature First</h3>
                        <p>Dubai's natural landscape is part of every story we tell. We favour respectful experiences and trusted guides who understand the desert, its wildlife and the communities that make it feel so special.</p>
                        <a href="{{ route('city-tours') }}">Discover city tours <i>→</i></a>
                    </div>
                </article>
            </section>

            <section class="why-us-cta" aria-label="Plan your Dubai trip">
                <div><span>READY WHEN YOU ARE</span><h2>Let's make your Dubai story unforgettable.</h2></div>
                <a href="{{ route('home') }}#plan-your-trip">Plan your trip <i>→</i></a>
            </section>
        </div>
    </div>
@endsection
