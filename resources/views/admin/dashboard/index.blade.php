@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    @php
        $adminName = auth()->user()?->name ?? 'Administrator';
        $initials = collect(explode(' ', $adminName))->filter()->map(fn ($part) => strtoupper(mb_substr($part, 0, 1)))->take(2)->implode('') ?: 'WM';
        $bookings = [
            ['guest' => 'Ayesha Khan', 'reference' => 'WMT-1048', 'experience' => 'Evening Desert Safari', 'date' => 'Today · 4 guests', 'amount' => 'AED 860', 'status' => 'Confirmed'],
            ['guest' => 'Michael Evans', 'reference' => 'WMT-1049', 'experience' => 'Dubai Marina Cruise', 'date' => 'Tomorrow · 2 guests', 'amount' => 'AED 510', 'status' => 'Pending'],
            ['guest' => 'Sara Ahmed', 'reference' => 'WMT-1050', 'experience' => 'Atlantis Aquaventure', 'date' => '01 Nov · 5 guests', 'amount' => 'AED 1,245', 'status' => 'Confirmed'],
            ['guest' => 'Daniel Wright', 'reference' => 'WMT-1051', 'experience' => 'Airport Transfer', 'date' => '02 Nov · 3 guests', 'amount' => 'AED 320', 'status' => 'New'],
        ];
    @endphp

    <div class="wmt-admin-shell">
        <aside class="wmt-admin-sidebar">
            <a class="wmt-admin-brand" href="{{ route('home') }}" aria-label="Open Waheed Murad Tourism website">
                <img src="{{ asset('images/waheed-murad-tourism-logo.jpeg') }}" alt="Waheed Murad Tourism">
                <span><strong>WAHEED MURAD</strong><small>TOURISM · ADMIN</small></span>
            </a>

            <p class="wmt-admin-label">WORKSPACE</p>
            <nav class="wmt-admin-nav" aria-label="Admin navigation">
                <a class="is-active" href="#overview"><i>▦</i> Overview</a>
                <a href="#bookings"><i>▤</i> Bookings <b>12</b></a>
                <a href="#experiences"><i>✦</i> Experiences</a>
                <a href="#guests"><i>◎</i> Guests</a>
                <a href="#reports"><i>⌁</i> Reports</a>
            </nav>

            <p class="wmt-admin-label">MANAGEMENT</p>
            <nav class="wmt-admin-nav" aria-label="Management navigation">
                <a href="{{ route('profile.edit') }}"><i>⚙</i> Account settings</a>
                <a href="{{ route('home') }}"><i>↗</i> View website</a>
            </nav>

            <div class="wmt-admin-help">
                <span>✦</span>
                <strong>Need a hand?</strong>
                <p>WMT support is one message away.</p>
                <a href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Chat on WhatsApp <i>→</i></a>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="wmt-admin-logout">
                @csrf
                <button type="submit"><span>↪</span> Sign out</button>
            </form>
        </aside>

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
                    <a href="#bookings">Review today’s bookings <i>→</i></a>
                </div>
                <div class="wmt-admin-hero-number"><b>128</b><span>GUESTS EXPLORING<br>WITH WMT THIS WEEK</span></div>
            </section>

            <section class="wmt-admin-stat-grid" aria-label="Business summary">
                <article><span class="gold">▤</span><p>Total bookings<small>↗ 12.5% from last week</small></p><strong>128</strong></article>
                <article><span class="coral">◇</span><p>Monthly revenue<small>↗ 8.2% from last month</small></p><strong>AED 48.6K</strong></article>
                <article><span class="teal">◎</span><p>New guests<small>16 arrivals today</small></p><strong>86</strong></article>
                <article><span class="blue">◷</span><p>Pending actions<small>5 need a reply</small></p><strong>12</strong></article>
            </section>

            <section class="wmt-admin-two-column" id="reports">
                <article class="wmt-admin-panel wmt-admin-revenue">
                    <div class="wmt-admin-panel-heading"><div><span>BOOKING PERFORMANCE</span><h2>Revenue overview</h2></div><button type="button">This month⌄</button></div>
                    <div class="wmt-admin-total"><strong>AED 48,640</strong><span>+8.2%</span></div>
                    <div class="wmt-admin-chart" aria-label="Weekly revenue chart"><i style="--value:48%"></i><i style="--value:72%"></i><i style="--value:56%"></i><i style="--value:86%"></i><i style="--value:66%"></i><i style="--value:94%"></i><i style="--value:78%"></i></div>
                    <div class="wmt-admin-chart-days"><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span></div>
                </article>
                <article class="wmt-admin-panel wmt-admin-feature" id="experiences">
                    <div class="wmt-admin-panel-heading"><div><span>TOP EXPERIENCE</span><h2>Desert safari leads</h2></div><a href="#bookings">View all →</a></div>
                    <img src="{{ asset('images/desert-safari.png') }}" alt="Desert safari in Dubai">
                    <div><strong>Evening Desert Safari</strong><p>42 bookings · AED 16,840 in revenue</p><span class="wmt-admin-progress"><i></i></span><small>84% of weekly booking target</small></div>
                </article>
            </section>

            <section class="wmt-admin-panel wmt-admin-bookings" id="bookings">
                <div class="wmt-admin-panel-heading"><div><span>LIVE ACTIVITY</span><h2>Recent bookings</h2></div><a href="#bookings">View all bookings →</a></div>
                <div class="wmt-admin-table-wrap"><table><thead><tr><th>Guest &amp; reference</th><th>Experience</th><th>Travel date</th><th>Amount</th><th>Status</th></tr></thead><tbody>@foreach ($bookings as $booking)<tr><td><strong>{{ $booking['guest'] }}</strong><small>{{ $booking['reference'] }}</small></td><td>{{ $booking['experience'] }}</td><td>{{ $booking['date'] }}</td><td><b>{{ $booking['amount'] }}</b></td><td><span class="wmt-admin-status {{ strtolower($booking['status']) }}">{{ $booking['status'] }}</span></td></tr>@endforeach</tbody></table></div>
            </section>

            <section class="wmt-admin-bottom-grid" id="guests">
                <article class="wmt-admin-panel"><div class="wmt-admin-panel-heading"><div><span>GUEST CARE</span><h2>Messages waiting</h2></div><b class="wmt-admin-count">5</b></div><div class="wmt-admin-message"><b>AK</b><p><strong>Ayesha Khan</strong><small>Could you confirm our desert pickup time?</small></p><em>10m</em></div><div class="wmt-admin-message"><b>ME</b><p><strong>Michael Evans</strong><small>Can we change our marina cruise date?</small></p><em>32m</em></div><a class="wmt-admin-text-link" href="https://wa.me/971500000000" target="_blank" rel="noopener noreferrer">Open guest support →</a></article>
                <article class="wmt-admin-quick"><span>QUICK ACTIONS</span><h2>Keep the day<br>moving.</h2><div><a href="#bookings"><b>＋</b>Create booking</a><a href="#experiences"><b>✦</b>Add experience</a><a href="#reports"><b>⌁</b>View reports</a></div></article>
            </section>
        </main>
    </div>
@endsection
