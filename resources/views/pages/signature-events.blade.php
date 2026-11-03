@extends('layouts.desert-adventures')

@section('title', 'Signature Events | Waheed Murad Tourism')

@section('content')
    <main class="event-page signature-page">
        <div class="event-page-container">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Signature Events']]" />

            <header class="signature-heading">
                <span>WMT EVENTS</span>
                <h1>Signature <em>Events</em></h1>
                <p>Unforgettable occasions, shaped with imagination and Dubai's distinctive sense of place.</p>
            </header>

            <section class="signature-showcase" aria-label="Al Waha desert event showcase">
                <img src="{{ asset('images/desert-camp-experience.png') }}" alt="An elegant evening event in the Dubai desert" fetchpriority="high">
                <div class="signature-showcase-shade"></div>
                <div class="signature-showcase-copy"><span>AL WAHA DESERT EVENT</span><strong>When the desert becomes your private venue.</strong></div>
                <div class="signature-showcase-dots" aria-hidden="true"><b></b><i></i><i></i><i></i></div>
            </section>

            <section class="signature-feature signature-feature--first">
                <img src="{{ asset('images/desert-dune-drive.png') }}" alt="Golden desert landscape for bespoke events" loading="lazy">
                <div><span>THE WMT STANDARD</span><h2>Meaningful moments, seamlessly managed.</h2><p>Our team brings together planning precision, local expertise and a genuine love for hosting. Each gathering feels effortless for your guests because every detail has been considered before they arrive.</p><a href="{{ route('meetings-incentives-events') }}">Meet our event team <i>→</i></a></div>
            </section>

            <section class="signature-feature signature-feature--reverse">
                <img src="{{ asset('images/camel-desert-journey.png') }}" alt="Camel journey experience in Dubai" loading="lazy">
                <div><span>YOUR EVENT, OUR EXPERTISE</span><h2>More than a venue. A true Dubai memory.</h2><ul><li>Award-winning desert experiences for private groups</li><li>Team building, camel polo and outdoor adventures</li><li>Bespoke dining and live entertainment concepts</li><li>Transport and guest management from start to finish</li></ul><a href="mailto:info@waheedmuradtourism.com">Start a conversation <i>→</i></a></div>
            </section>

            <section class="signature-cases" aria-labelledby="signature-cases-title">
                <div class="signature-cases-heading"><span>CASE STUDIES</span><h2 id="signature-cases-title">Events with a story to tell.</h2><p>Every programme is shaped to suit its audience, from private celebrations to destination-wide corporate gatherings.</p></div>
                <div class="signature-case-grid">
                    <article><img src="{{ asset('images/sports-events-dubai.png') }}" alt="Dubai event celebration" loading="lazy"><h3>Desert gala evenings</h3><p>Dining, entertainment and a setting guests never forget.</p></article>
                    <article><img src="{{ asset('images/dubai-adventure.png') }}" alt="Dubai city skyline event experience" loading="lazy"><h3>City celebrations</h3><p>Iconic settings for vibrant, beautifully hosted occasions.</p></article>
                    <article><img src="{{ asset('images/sports-golf-dubai.png') }}" alt="Corporate sporting experience in Dubai" loading="lazy"><h3>Team experiences</h3><p>Shared challenges, connection and unforgettable local moments.</p></article>
                </div>
            </section>

            <section class="event-enquiry signature-enquiry">
                <div><span>YOUR NEXT SIGNATURE EVENT</span><h2>Ready to make an impression?</h2><p>Our team is ready to turn your idea into a Dubai experience worth talking about.</p></div>
                <a href="mailto:info@waheedmuradtourism.com">Enquire today <i>→</i></a>
            </section>
        </div>
    </main>
@endsection
