@extends('layouts.site')

@section('title', 'Sustainable Tourism | Waheed Murad Tourism')
@section('meta_description', 'Discover how Waheed Murad Tourism supports responsible travel, desert conservation and local communities.')

@section('content')
    <section class="sustainability-page">
        <div class="sustainability-container">
            <section class="sustainability-hero">
                <img src="{{ asset('images/safaris/wide-view-of-desert-camp.jpg') }}" alt="Desert wildlife in a protected Dubai landscape" fetchpriority="high">
                <div>
                    <span>RESPONSIBLE TRAVEL</span>
                    <h1>Sustainable Tourism</h1>
                    <p>We protect the desert, support communities and create thoughtful experiences in every journey.</p>
                </div>
            </section>

            <section class="sustainability-section">
                <h2>Operating sustainably</h2>
                <article class="sustainability-split">
                    <img src="{{ asset('images/desert-experiences/exclusive-desert-experience/02.webp') }}" alt="Responsible desert safari vehicle at sunset" loading="lazy">
                    <div>
                        <span class="sustainability-kicker">OUR COMMITMENT</span>
                        <h3>Responsible journeys, measured carefully</h3>
                        <p>We continuously improve how our experiences are planned and delivered, with practical standards for environmental care, team wellbeing and responsible supplier choices.</p>
                        <p>Our goal is simple: give guests memorable Dubai experiences while reducing our impact and respecting the places that make every journey special.</p>
                        <a href="#policy">Read our sustainability policy <b>→</b></a>
                    </div>
                </article>
            </section>

            <section class="sustainability-mission">
                <span>OUR MISSION</span>
                <h2>Travel that gives back to Dubai.</h2>
                <p>We create high-quality experiences that celebrate local culture, care for fragile desert ecosystems and leave a positive impact on the communities that welcome our guests.</p>
            </section>

            <section class="sustainability-section">
                <h2>Preserving our home</h2>
                <article class="sustainability-split">
                    <img src="{{ asset('images/why-us/nature-first.jpg') }}" alt="Dubai desert conservation landscape" loading="lazy">
                    <div>
                        <span class="sustainability-kicker">CONSERVATION</span>
                        <h3>Dubai Desert Conservation Reserve</h3>
                        <p>Dubai’s desert is home to remarkable wildlife and heritage. Our safaris are designed with conservation in mind, from mindful routing and waste management to sharing the story of the landscape with every guest.</p>
                        <p>We work to ensure that the places we visit remain protected and thriving for generations to come.</p>
                    </div>
                </article>
                <article class="sustainability-split sustainability-split-reverse">
                    <img src="{{ asset('images/buggies-school/morning-wildlife-safari/06.jpg') }}" alt="Wildlife in Dubai's desert" loading="lazy">
                    <div>
                        <span class="sustainability-kicker">ANIMAL WELFARE</span>
                        <h3>Respect for wildlife</h3>
                        <p>Wild animals and desert habitats deserve care. We follow responsible practices for every wildlife encounter, with guest safety, animal welfare and habitat protection at the centre of each decision.</p>
                    </div>
                </article>
                <article class="sustainability-split" id="policy">
                    <img src="{{ asset('images/desert-experiences/morning-desert-adventure-hot-air-balloon-combo/03.webp') }}" alt="Guests preparing for a responsible Dubai experience" loading="lazy">
                    <div>
                        <span class="sustainability-kicker">OUR POLICY</span>
                        <h3>Making responsible choices</h3>
                        <p>Our sustainability policy guides how we operate: reducing waste, choosing considered partners, supporting people and protecting the environments where we work.</p>
                        <a href="{{ route('why-us') }}">Explore our approach <b>→</b></a>
                    </div>
                </article>
            </section>

            <section class="sustainability-section">
                <h2>Empowering our communities</h2>
                <div class="sustainability-community-grid">
                    <article><img src="{{ asset('images/desert-experiences/the-veuve-clicquot-desert-experience/02.webp') }}" alt="Local community member at work" loading="lazy"><div><h3>Supporting opportunity</h3><p>We champion inclusive opportunities that help people build confidence, practical skills and meaningful careers.</p></div></article>
                    <article><img src="{{ asset('images/desert-experiences/exclusive-desert-experience/04.webp') }}" alt="Safari guide in Dubai desert" loading="lazy"><div><h3>Supporting education</h3><p>Our teams share local knowledge and continue learning through professional training and recognised standards.</p></div></article>
                    <article><img src="{{ asset('images/desert-experiences/morning-desert-adventure-hot-air-balloon-combo/06.webp') }}" alt="Dubai tourism vehicle in the desert" loading="lazy"><div><h3>Local employment</h3><p>We create pathways for local talent and work to provide fair, consistent opportunities across our business.</p></div></article>
                </div>
            </section>

            <section class="sustainability-section">
                <h2>Celebrating Emirati culture</h2>
                <article class="sustainability-split">
                    <img src="{{ asset('images/city-tours/abu-dhabi-heritage-tour/02.jpg') }}" alt="Emirati heritage and craftsmanship" loading="lazy">
                    <div><span class="sustainability-kicker">LOCAL HERITAGE</span><h3>Rooted in Emirati heritage</h3><p>From warm welcomes and traditional hospitality to stories of the desert, our experiences honour the culture, craftsmanship and traditions that shape the UAE.</p></div>
                </article>
                <article class="sustainability-split sustainability-split-reverse">
                    <img src="{{ asset('images/city-tours/abu-dhabi-heritage-tour/04.jpg') }}" alt="Dubai skyline and cultural landmarks" loading="lazy">
                    <div><span class="sustainability-kicker">THE UAE</span><h3>Showcasing the UAE to the world</h3><p>We help visitors discover a modern country with a deep cultural identity, connecting every tour with the places, people and stories that make the UAE distinctive.</p></div>
                </article>
                <article class="sustainability-split">
                    <img src="{{ asset('images/why-us/desert-nights.jpg') }}" alt="Protected Dubai desert at sunset" loading="lazy">
                    <div><span class="sustainability-kicker">ETHICAL PRACTICES</span><h3>Encouraging thoughtful travel</h3><p>We encourage guests to travel with care: respect wildlife, value local culture and choose experiences that protect the places they love to explore.</p><a href="{{ route('home') }}#contact">Talk to our team <b>→</b></a></div>
                </article>
            </section>
        </div>
    </section>
@endsection
