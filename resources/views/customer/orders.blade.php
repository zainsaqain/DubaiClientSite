@extends('layouts.site')

@section('title', 'Order History | Waheed Murad Tourism')

@section('content')
    <section class="customer-account-page">
        <div class="customer-account-container">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'My Account', 'url' => route('account.dashboard')], ['label' => 'Order History']]" />
            <header class="customer-account-heading">
                <span>YOUR BOOKINGS</span>
                <h1>Order History</h1>
                <p>Keep track of every experience you have booked, including payment and confirmation updates.</p>
            </header>

            @include('customer.partials.navigation')

            @if ($bookings->isNotEmpty())
                <section class="customer-orders-list" aria-label="Your orders">
                    @foreach ($bookings as $booking)
                        @php
                            $paymentStatus = match ($booking->payment_status) {
                                'paid' => 'Payment verified',
                                'pending_verification' => 'Payment under review',
                                'rejected' => 'Payment needs attention',
                                default => 'Payment pending',
                            };
                            $statusClass = match ($booking->payment_status) {
                                'paid' => 'is-confirmed',
                                'rejected' => 'is-action-required',
                                default => 'is-pending',
                            };
                        @endphp

                        <article class="customer-order-card">
                            <div class="customer-order-card-header">
                                <div>
                                    <span>ORDER {{ $booking->order_number }}</span>
                                    <h2>{{ $booking->tour?->name ?? 'Booked experience' }}</h2>
                                </div>
                                <span class="customer-order-status {{ $statusClass }}">{{ $paymentStatus }}</span>
                            </div>

                            <dl class="customer-order-details">
                                <div><dt>Travel date</dt><dd>{{ $booking->travel_date->format('d M Y') }}</dd></div>
                                <div><dt>Guests</dt><dd>{{ $booking->adults }} adult{{ $booking->adults === 1 ? '' : 's' }}@if ($booking->children) · {{ $booking->children }} child{{ $booking->children === 1 ? '' : 'ren' }}@endif @if ($booking->infants) · {{ $booking->infants }} infant{{ $booking->infants === 1 ? '' : 's' }}@endif</dd></div>
                                <div><dt>Total</dt><dd>{{ $booking->currency }} {{ number_format((float) $booking->amount, 2) }}</dd></div>
                            </dl>

                            <div class="customer-order-card-footer">
                                <p>Booked {{ $booking->created_at->format('d M Y') }}</p>
                                <a href="{{ route('bank-transfer.show', $booking) }}">
                                    {{ in_array($booking->payment_status, ['pending_payment', 'rejected'], true) ? 'Continue payment' : 'View payment details' }} <span>→</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </section>
            @else
                <section class="customer-empty-state">
                    <span>✦</span>
                    <h2>No orders placed yet</h2>
                    <p>When you book an experience, its details and status will be available here.</p>
                    <a href="{{ route('home') }}#experiences">Explore experiences <b>→</b></a>
                </section>
            @endif
        </div>
    </section>
@endsection
