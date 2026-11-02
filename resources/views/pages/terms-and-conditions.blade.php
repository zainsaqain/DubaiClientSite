@extends('layouts.desert-adventures')

@section('title', 'Terms and Conditions | Waheed Murad Tourism')

@section('content')
    <main class="legal-page">
        <section class="legal-hero legal-hero--blue">
            <div class="legal-container"><x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Terms and Conditions']]" /><span>BOOKING INFORMATION</span><h1>Terms <em>&amp; Conditions</em></h1><p>The important information that supports a transparent booking experience.</p></div>
        </section>
        <div class="legal-container legal-layout">
            <article class="legal-content legal-content--terms">
                <section><span>1. YOUR BOOKING</span><h2>Booking agreement</h2><p>When you confirm a booking with Waheed Murad Tourism, you agree to the terms provided for that experience, including any supplier, venue or transport conditions that apply to the selected activity.</p></section>
                <section><span>2. PAYMENTS</span><h2>Prices and payment</h2><p>Prices are displayed in the currency stated at checkout. Payment requirements, inclusions and any applicable taxes or supplier charges are shown before confirmation. Your bank or payment provider may apply its own fees.</p></section>
                <section><span>3. EXPERIENCE DETAILS</span><h2>Changes to an experience</h2><p>Activity schedules, routes, inclusions and timings may need to change because of weather, operations, local regulations or supplier requirements. We will make reasonable efforts to let you know about material changes.</p></section>
                <section><span>4. GUEST RESPONSIBILITIES</span><h2>Participation and safety</h2><p>Guests are responsible for providing accurate booking details and following the safety instructions of guides, drivers and activity operators. Some experiences involve physical activity or natural environments and may not be suitable for every guest.</p></section>
                <section><span>5. THIRD-PARTY SERVICES</span><h2>Our local partners</h2><p>Some services are delivered by carefully selected third-party operators. Their activity-specific rules, safety requirements and cancellation terms may apply alongside these general booking conditions.</p></section>
                <section><span>6. CANCELLATIONS</span><h2>Cancellation and refunds</h2><p>Cancellation requests are managed in line with the policy for your selected product. Please review our <a href="{{ route('cancellation-refund-policy') }}">Cancellation &amp; Refund Policy</a> and the terms shown with your booking confirmation.</p></section>
                <section><span>7. GOVERNING INFORMATION</span><h2>Contact and support</h2><p>For questions about these terms or a current reservation, contact our team before travel. These website terms are provided as general booking information and may be updated as services evolve.</p></section>
            </article>
            @include('components.site.legal-support')
        </div>
    </main>
@endsection
