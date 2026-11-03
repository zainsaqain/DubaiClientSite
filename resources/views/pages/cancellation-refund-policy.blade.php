@extends('layouts.desert-adventures')

@section('title', 'Cancellation & Refund Policy | Waheed Murad Tourism')

@section('content')
    <main class="legal-page">
        <section class="legal-hero legal-hero--warm">
            <div class="legal-container"><x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Cancellation & Refund Policy']]" /><span>BOOK WITH CLARITY</span><h1>Cancellation <em>&amp; Refund Policy</em></h1><p>Clear guidance when travel plans need to change.</p></div>
        </section>
        <div class="legal-container legal-layout">
            <article class="legal-content">
                <section><span>CHANGES TO YOUR PLAN</span><h2>Changes and cancellations</h2><p>Plans can change. If you need to amend or cancel a booking, please contact our team as early as possible with your booking reference and the details of your request.</p><ul><li>Availability, prices, activity routes and schedules may change where operationally required.</li><li>Changes are subject to supplier availability and the conditions of the booked experience.</li><li>We will always aim to offer the most helpful available option for your travel plans.</li></ul></section>
                <section><span>REFUNDS</span><h2>When a refund may apply</h2><p>Eligibility depends on the experience, package and timing of the request. Where a refund is approved, it is returned through the original payment method where possible.</p><div class="legal-note"><b>Important</b><p>Cancellation terms shown during booking and on your confirmation apply to your reservation. Some promotional, special-event or third-party tickets may have separate conditions.</p></div><ul><li>Requests made close to the experience start time may be subject to supplier charges.</li><li>Failure to arrive at the stated meeting point may be treated as a no-show.</li><li>Processing times can vary depending on the original payment provider.</li></ul></section>
                <section><span>UNFORESEEN CIRCUMSTANCES</span><h2>Operational changes</h2><p>Guest safety comes first. In rare cases, an activity may need to be adjusted, postponed or cancelled because of weather, government guidance, venue access or other events beyond reasonable control.</p><p>When this happens, our team will communicate the available next step, which may include an alternative arrangement, a rescheduled date or a refund in line with the applicable booking terms.</p></section>
                <section><span>NEED HELP?</span><h2>We're here to assist</h2><p>Contact our local support team with your booking reference. We will review the details and help you understand the options available for your reservation.</p></section>
            </article>
            @include('components.site.legal-support')
        </div>
    </main>
@endsection
