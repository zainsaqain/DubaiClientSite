@extends('layouts.desert-adventures')

@section('title', 'Where to Find Us | Waheed Murad Tourism')

@push('page-assets')
    @vite('resources/css/company-pages.css')
@endpush

@section('content')
    <section class="company-find-reference">
        <div class="company-find-title"><div><h1>Where to Find Us</h1></div></div>

        <div class="company-find-content">
            <p class="company-find-lead">Our team is here to make your Dubai experience hassle-free. Reach us in the way that suits you best—before you arrive, during your stay or whenever you need local travel advice.</p>

            <section class="company-find-dubai" aria-label="Waheed Murad Tourism in Dubai">
                <img src="{{ asset('images/cruise-dubai-marina.png') }}" alt="Dubai's coastline and marina">
                <h2>In Dubai</h2>
            </section>

            <section class="company-find-locations" aria-label="Dubai locations we serve">
                <ul>
                    <li>Downtown Dubai</li>
                    <li>Dubai Marina &amp; JBR</li>
                    <li>Palm Jumeirah</li>
                    <li>Business Bay</li>
                </ul>
                <ul>
                    <li>Old Dubai &amp; Deira</li>
                    <li>Jumeirah Beach</li>
                    <li>Dubai Creek</li>
                    <li>Dubai Desert Conservation Reserve</li>
                </ul>
            </section>

            <section class="company-find-contact" aria-label="Contact Waheed Murad Tourism">
                <div><h2>Next Step</h2><a href="{{ route('home') }}#booking">Make an enquiry</a></div>
                <div><h2>Customer Support</h2><p><a href="tel:+971502299598">+971 50 229 9598</a><br><a href="https://wa.me/971502299598" target="_blank" rel="noopener noreferrer">WhatsApp our travel desk</a></p><p><a href="mailto:hello@waheedmuradtourism.com">hello@waheedmuradtourism.com</a></p></div>
                <div><h2>Address</h2><p>Downtown Dubai<br>Dubai, United Arab Emirates</p><p>Daily support for guests across Dubai.</p></div>
                <div><h2>Email Routing</h2><p><a href="mailto:hello@waheedmuradtourism.com">Bookings &amp; enquiries</a></p><p><a href="mailto:hello@waheedmuradtourism.com">Travel trade partnerships</a></p></div>
            </section>
        </div>
    </section>
@endsection
