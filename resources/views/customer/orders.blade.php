@extends('layouts.site')

@section('title', 'Order History | Waheed Murad Tourism')

@section('content')
    <section class="customer-account-page"><div class="customer-account-container"><x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'My Account', 'url' => route('account.dashboard')], ['label' => 'Order History']]" /><header class="customer-account-heading"><span>YOUR BOOKINGS</span><h1>Order History</h1><p>All confirmed bookings will appear here.</p></header>@include('customer.partials.navigation')<section class="customer-empty-state"><span>✦</span><h2>No orders placed yet</h2><p>When you book an experience, its details and status will be available here.</p><a href="{{ route('home') }}#experiences">Explore experiences <b>→</b></a></section></div></section>
@endsection
