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
                @foreach ($features as $feature)
                    <article class="why-us-feature-row {{ $feature->is_reversed ? 'why-us-feature-row-reverse' : '' }}">
                        <div class="why-us-feature-media"><img src="{{ asset($feature->publicImagePath()) }}" alt="{{ $feature->title }}" loading="lazy"></div>
                        <div class="why-us-feature-copy">
                            <span>{{ $feature->eyebrow }}</span>
                            <h3>{{ $feature->title }}</h3>
                            <p>{{ $feature->description }}</p>
                            @if ($feature->link_label && $feature->link_url)
                                <a href="{{ url($feature->link_url) }}">{{ $feature->link_label }} <i>→</i></a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </section>

            <section class="why-us-cta" aria-label="Plan your trip">
                <div><span>READY WHEN YOU ARE</span><h2>Let's make your Dubai story unforgettable.</h2></div>
                <a href="{{ route('home') }}#plan-your-trip">Plan your trip <i>→</i></a>
            </section>
        </div>
    </div>
@endsection
