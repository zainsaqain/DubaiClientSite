@extends('layouts.desert-adventures')

@section('title', 'Meetings, Incentives & Events | Waheed Murad Tourism')

@section('content')
    <main class="event-page mie-page">
        <div class="event-page-container">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Meetings, Incentives & Events']]" />

            <section class="event-hero event-hero--meetings" aria-labelledby="meetings-title">
                <img src="{{ asset('images/desert-camp-experience.png') }}" alt="Private event dinner in the Dubai desert" fetchpriority="high">
                <div class="event-hero-overlay"></div>
                <div class="event-hero-copy">
                    <span>WMT EVENTS</span>
                    <h1 id="meetings-title">Meetings, Incentives <em>&amp; Events</em></h1>
                    <p>Extraordinary Dubai events, thoughtfully created from the first idea to the final farewell.</p>
                    <a href="#enquire">Plan an event <i>→</i></a>
                </div>
            </section>

            <section class="event-intro" aria-labelledby="meetings-intro-title">
                <span>DESIGNED AROUND YOUR PEOPLE</span>
                <h2 id="meetings-intro-title">Make every gathering <em>matter.</em></h2>
                <p>From intimate leadership retreats to large-scale incentive programmes, our Dubai team combines creative ideas, trusted local access and warm hospitality to make each event feel entirely yours.</p>
            </section>

            <section class="event-story-list" aria-label="Meetings and events services">
                <article class="event-story">
                    <img src="{{ asset('images/airport-transfer.png') }}" alt="Guests arriving for a Dubai event" loading="lazy">
                    <div>
                        <span>ABOUT US</span>
                        <h2>Local knowledge, beautifully delivered.</h2>
                        <p>Our event specialists turn the UAE into your canvas. We shape every detail around your guests, programme and brand—from transport and venue sourcing to thoughtful moments no one saw coming.</p>
                        <ul><li>Dedicated event specialists</li><li>Trusted Dubai venue network</li><li>One team from planning to on-site delivery</li></ul>
                    </div>
                </article>
                <article class="event-story event-story--reverse">
                    <img src="{{ asset('images/cruise-dubai-marina.png') }}" alt="A private luxury experience on Dubai waters" loading="lazy">
                    <div>
                        <span>OUR SERVICES</span>
                        <h2>From city energy to desert calm.</h2>
                        <p>Build an incentive with a sunrise dune drive, a private yacht evening, a cultural journey through old Dubai, or an all-out celebration beneath the stars. Every experience is tailored to your guests.</p>
                        <a href="{{ route('home') }}#experiences">Explore experiences <i>→</i></a>
                    </div>
                </article>
                <article class="event-story">
                    <img src="{{ asset('images/desert-oasis-morning.png') }}" alt="A peaceful desert setting near Dubai" loading="lazy">
                    <div>
                        <span>OUR LOCATIONS</span>
                        <h2>One destination, endless possibilities.</h2>
                        <p>Dubai offers iconic city views, golden desert landscapes and coastline escapes within easy reach. We match every group with spaces and experiences that make the most of the destination.</p>
                        <a href="{{ route('where-to-find-us') }}">Discover Dubai <i>→</i></a>
                    </div>
                </article>
            </section>

            <section class="event-stats" aria-label="Event planning benefits">
                <article><strong>1</strong><span>Dedicated<br>event partner</span></article>
                <article><strong>24/7</strong><span>Local support<br>on the ground</span></article>
                <article><strong>∞</strong><span>Ways to make<br>it memorable</span></article>
            </section>

            <section class="event-enquiry" id="enquire">
                <div><span>READY TO BEGIN?</span><h2>Let's create your next unforgettable event.</h2><p>Tell us the occasion, group size and your first idea. We will take it from there.</p></div>
                <a href="mailto:info@waheedmuradtourism.com">Enquire today <i>→</i></a>
            </section>
        </div>
    </main>
@endsection
