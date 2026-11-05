@extends('admin.layouts.app')

@section('title', 'Bookings')

@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')

    <main class="wmt-admin-main wmt-admin-manager-main">
        <header class="wmt-admin-topbar">
            <div>
                <p>BOOKING MANAGEMENT</p>
                <h1>Confirmed Bookings</h1>
            </div>
        </header>

        <section class="wmt-admin-panel">
            <div class="wmt-admin-panel-heading">
                <div>
                    <span>PAYMENT VERIFIED</span>
                    <h2>Ready to deliver</h2>
                </div>
                <span class="wmt-admin-count">{{ $bookings->total() }}</span>
            </div>

            @if ($bookings->isEmpty())
                <div class="wmt-admin-empty">
                    <h3>No confirmed bookings yet.</h3>
                    <p>Bookings will appear here as soon as their bank transfer payment is approved.</p>
                </div>
            @else
                <div class="wmt-manager-table-wrap">
                    <table class="wmt-manager-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Experience</th>
                                <th>Travel date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td><strong>{{ $booking->order_number }}</strong><small>Confirmed {{ $booking->updated_at->format('d M Y') }}</small></td>
                                    <td>{{ $booking->user->name }}<small>{{ $booking->user->email }}</small></td>
                                    <td>{{ $booking->tour->name }}<small>{{ $booking->adults }} adult{{ $booking->adults === 1 ? '' : 's' }}@if ($booking->children) · {{ $booking->children }} child{{ $booking->children === 1 ? '' : 'ren' }}@endif</small></td>
                                    <td>{{ $booking->travel_date->format('d M Y') }}</td>
                                    <td><strong>{{ $booking->currency }} {{ number_format((float) $booking->amount, 2) }}</strong></td>
                                    <td><span class="wmt-admin-status confirmed">Confirmed</span></td>
                                    <td>
                                        @if ($booking->bankTransferPayment)
                                            <a href="{{ route('admin.bank-transfer-payments.show', $booking->bankTransferPayment) }}">View payment</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $bookings->links() }}
            @endif
        </section>
    </main>
</div>
@endsection
