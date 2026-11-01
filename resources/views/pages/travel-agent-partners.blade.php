@extends('layouts.desert-adventures')

@section('title', 'Travel Agent Partners | Waheed Murad Tourism')

@push('page-assets')
    @vite('resources/css/company-pages.css')
@endpush

@section('content')
    <section class="company-partners-reference">
        <div class="company-partners-container">
            <section class="company-partners-hero" aria-label="Travel agent partnership hero">
                <img src="{{ asset('images/cruise-dubai-marina.png') }}" alt="Dubai's coast and marina skyline">
                <div>
                    <h1>Dubai experiences,<br>made for your guests.</h1>
                    <p>Waheed Murad Tourism combines trusted local knowledge, carefully selected experiences and reliable on-the-ground support for travel professionals.</p>
                    <a href="{{ route('home') }}#contact">Enquire today</a>
                </div>
            </section>

            <section class="company-partners-overview" aria-labelledby="partners-overview-title">
                <h2 id="partners-overview-title">Why partner with Waheed Murad Tourism?</h2>
                <p>We make it simple to build memorable Dubai programmes. From individual holidays to group travel, our local team brings together the right experiences, clear communication and the warm hospitality your guests remember.</p>
            </section>

            <section class="company-partners-benefits" aria-label="Partner benefits">
                <article><b>⌖</b><h3>Customised leisure group<br>experiences</h3><p>Every programme is shaped around the group, their interests and their pace.</p></article>
                <article><b>✦</b><h3>Individual and VIP travel<br>options</h3><p>Flexible arrangements for guests who want Dubai their own way.</p></article>
                <article><b>◷</b><h3>End-to-end event<br>management</h3><p>Local expertise and dependable support from enquiry to departure.</p></article>
            </section>

            <section class="company-partners-services" aria-labelledby="partners-services-title">
                <h2 id="partners-services-title">Our Services</h2>

                <article class="company-partners-service"><img src="{{ asset('images/desert-safari.png') }}" alt="Dubai desert travel experience" loading="lazy"><div><h3>Travel Trade</h3><p>Build confident Dubai itineraries with desert safaris, city experiences, attraction tickets, transfers and more. Our experienced local team helps travel partners match every guest with the right experience.</p><a href="{{ route('desert-adventures') }}">Learn more</a></div></article>
                <article class="company-partners-service company-partners-service--reverse"><img src="{{ asset('images/desert-camp-experience.png') }}" alt="Private desert dinner setup" loading="lazy"><div><h3>Cruise Handling</h3><p>Make every port day feel effortless with tailored shore experiences, transport coordination and thoughtful local support for cruise guests arriving in Dubai.</p><a href="{{ route('home') }}#contact">Learn more</a></div></article>
                <article class="company-partners-service"><img src="{{ asset('images/sports-events-dubai.png') }}" alt="Dubai sporting event" loading="lazy"><div><h3>Meetings, Incentives &amp; Events</h3><p>From intimate celebrations to larger incentive programmes, we help create distinctive moments with a local point of view and careful end-to-end coordination.</p><a href="{{ route('home') }}#contact">Learn more</a></div></article>
                <article class="company-partners-service company-partners-service--reverse"><img src="{{ asset('images/dubai-attractions.png') }}" alt="Dubai city attractions" loading="lazy"><div><h3>Travel, Ticketing and Visas</h3><p>Support your guests beyond the experience with practical local travel guidance, attraction access and the information they need for a smoother journey.</p><a href="{{ route('home') }}#contact">Learn more</a></div></article>
            </section>

            <section class="company-partners-destinations" aria-labelledby="partner-destinations-title">
                <h2 id="partner-destinations-title">Our Destinations</h2>
                <div>
                    <article><img src="{{ asset('images/dubai-adventure.png') }}" alt="Dubai skyline" loading="lazy"><h3>Dubai</h3><p>Skyline views, heritage neighbourhoods, desert escapes and waterfront moments in one remarkable city.</p></article>
                    <article><img src="{{ asset('images/desert-oasis-morning.png') }}" alt="Dubai desert oasis" loading="lazy"><h3>Dubai Desert</h3><p>Golden dunes, wildlife and immersive experiences that show guests another side of the UAE.</p></article>
                    <article><img src="{{ asset('images/cruise-dubai-marina.png') }}" alt="Dubai waterfront" loading="lazy"><h3>Dubai Waterfront</h3><p>Marinas, cruises and coastal experiences designed for memorable days by the Arabian Gulf.</p></article>
                </div>
            </section>

            <section class="company-partners-cta"><h2>Let's create your next Dubai programme.</h2><p>Tell us about your guests, timing and ideas—our local team is ready to help.</p><a href="{{ route('home') }}#contact">Enquire now</a></section>
        </div>
    </section>
@endsection
