@extends('layouts.desert-adventures')

@section('title', 'Travel Guidelines | Waheed Murad Tourism')

@section('content')
    <main class="legal-page">
        <section class="legal-hero">
            <div class="legal-container"><x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Guidelines']]" /><span>TRAVEL WITH CONFIDENCE</span><h1>Travel <em>Guidelines</em></h1><p>Useful information for a smooth, comfortable and respectful Dubai experience.</p></div>
        </section>
        <div class="legal-container legal-layout">
            <article class="legal-content">
                <section><span>BEFORE YOU BOOK</span><h2>How to book</h2><p>Choose your preferred experience online, then complete your booking with the details requested. Our team can also help by phone or WhatsApp if you need advice before confirming.</p><ul><li>Review your experience details, date and guest information before payment.</li><li>Some activities have specific age, health, clothing or participation requirements.</li><li>Keep your booking confirmation available on the day of your experience.</li></ul></section>
                <section><span>ON THE ROAD</span><h2>Transfers and safari vehicles</h2><p>Guest comfort and safety guide every journey. All passengers must follow the instructions shared by the driver or guide, including wearing seat belts whenever the vehicle is in motion.</p><div class="legal-note"><b>For families</b><p>Child seats or booster seats may be required depending on a child's age and height. Please request these in advance so we can prepare the suitable vehicle.</p></div><ul><li>Seating in shared safari vehicles is arranged by the operating team.</li><li>For desert activities, choose comfortable clothing and closed shoes where advised.</li><li>Please arrive at the meeting point at the time shown on your confirmation.</li></ul></section>
                <section><span>GOOD TO KNOW</span><h2>Enjoy Dubai respectfully</h2><p>Dubai welcomes visitors from around the world. A little local awareness helps everyone have a great time.</p><ul><li>Ask permission before taking photographs of people, especially in cultural settings.</li><li>Dress respectfully when visiting heritage areas, mosques and public places.</li><li>Stay hydrated and use sunscreen during outdoor experiences.</li><li>Follow your guide's instructions around wildlife, dunes, water and activity equipment.</li></ul></section>
                <section><span>SEASONAL TRAVEL</span><h2>Weather and special occasions</h2><p>Dubai is sunny for much of the year. Temperatures can vary between day and evening, especially in the desert. During Ramadan and public holidays, operating times or included services may be adjusted.</p></section>
            </article>
            @include('components.site.legal-support')
        </div>
    </main>
@endsection
