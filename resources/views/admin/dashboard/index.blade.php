@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    @php
        $adminName = auth()->user()?->name ?? 'Administrator';
        $initials = collect(explode(' ', $adminName))->filter()->map(fn ($part) => strtoupper(mb_substr($part, 0, 1)))->take(2)->implode('') ?: 'WM';
    @endphp

    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')

        <main class="wmt-admin-main" id="overview">
            <header class="wmt-admin-topbar">
                <div>
                    <p>WAHEED MURAD TOURISM</p>
                    <h1>Good morning, {{ $adminName }}.</h1>
                </div>
                <div class="wmt-admin-actions">
                    <a class="wmt-admin-site-link" href="{{ route('home') }}">Open website <span>↗</span></a>
                    <a class="wmt-admin-account" href="{{ route('profile.edit') }}" aria-label="Open account settings">
                        <b>{{ $initials }}</b>
                        <span><strong>{{ $adminName }}</strong><small>Administrator</small></span>
                    </a>
                </div>
            </header>

            <section class="wmt-admin-hero">
                <div class="wmt-admin-hero-copy">
                    <span>OPERATIONS OVERVIEW</span>
                    <h2>Every journey,<br><em>beautifully managed.</em></h2>
                    <p>Keep a clear view of today’s guests, bookings and your most-loved Dubai experiences.</p>
                    <a href="{{ route('admin.bookings.index') }}">Review confirmed bookings <i>→</i></a>
                </div>
                <div class="wmt-admin-hero-number"><b>{{ $dashboardMetrics['confirmed_bookings'] }}</b><span>CONFIRMED<br>BOOKINGS</span></div>
            </section>

            <section class="wmt-admin-stat-grid" aria-label="Business summary">
                <article><span class="gold">▤</span><p>Total bookings<small>All orders received</small></p><strong>{{ $dashboardMetrics['total_bookings'] }}</strong></article>
                <article><span class="coral">◇</span><p>Verified payment total<small>Approved bank transfers</small></p><strong>AED {{ number_format($dashboardMetrics['verified_payment_total'], 2) }}</strong></article>
                <article><span class="teal">◎</span><p>Confirmed bookings<small>Ready to deliver</small></p><strong>{{ $dashboardMetrics['confirmed_bookings'] }}</strong></article>
                <article><span class="blue">◷</span><p>Pending bookings<small>Payment or review pending</small></p><strong>{{ $dashboardMetrics['pending_bookings'] }}</strong></article>
            </section>

            <section class="wmt-admin-two-column" id="reports">
                <article class="wmt-admin-panel wmt-admin-revenue">
                    <div class="wmt-admin-panel-heading"><div><span>BOOKING PERFORMANCE</span><h2>Revenue overview</h2></div><button type="button">This month</button></div>
                    <div class="wmt-admin-total"><strong>AED {{ number_format($dashboardMetrics['monthly_payment_total'], 2) }}</strong><span>Verified</span></div>
                    <div class="wmt-admin-chart" aria-label="Weekly verified payment chart">@foreach ($weeklyRevenue as $revenue)<i style="--value: {{ max(6, round(($revenue['amount'] / $maximumWeeklyRevenue) * 100)) }}%"></i>@endforeach</div>
                    <div class="wmt-admin-chart-days">@foreach ($weeklyRevenue as $revenue)<span>{{ $revenue['label'] }}</span>@endforeach</div>
                </article>
                <article class="wmt-admin-panel wmt-admin-feature" id="experiences">
                    <div class="wmt-admin-panel-heading"><div><span>TOP EXPERIENCE</span><h2>{{ $topExperience?->tour?->name ?? 'No confirmed bookings yet' }}</h2></div><a href="{{ route('admin.bookings.index') }}">View bookings →</a></div>
                    @if ($topExperience?->tour)
                        <img src="{{ $topExperience->tour->imageUrl() }}" alt="{{ $topExperience->tour->image_alt ?: $topExperience->tour->name }}">
                        <div><strong>{{ $topExperience->tour->name }}</strong><p>{{ $topExperience->booking_count }} confirmed booking{{ (int) $topExperience->booking_count === 1 ? '' : 's' }} · AED {{ number_format((float) $topExperience->payment_total, 2) }} in verified payments</p></div>
                    @else
                        <div><p>Confirmed bookings will reveal your top experience here.</p></div>
                    @endif
                </article>
            </section>

        </main>
    </div>
@endsection
