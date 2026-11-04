@extends('layouts.site')

@section('title', 'My Account | Waheed Murad Tourism')

@section('content')
    <section class="customer-account-page">
        <div class="customer-account-container">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'My Account']]" />
            <header class="customer-account-heading"><span>YOUR TRAVEL SPACE</span><h1>My Account</h1><p>Manage your personal details, bookings and saved experiences in one place.</p></header>
            @include('customer.partials.navigation')

            <div class="customer-account-grid">
                <article class="customer-account-card customer-account-profile-card"><div><span>PROFILE</span><h2>{{ $user->first_name ?: $user->name }}</h2><p>{{ $user->email }}</p><p>{{ $user->phone_country_code }} {{ $user->phone_number }}</p><p>{{ $user->country_of_residence }}</p></div><a href="{{ route('account.profile') }}">Edit profile <span>→</span></a></article>
                <article class="customer-account-card"><span>BOOKINGS</span><h2>Order History</h2><p>You have no recent orders yet.</p><a href="{{ route('account.orders') }}">View orders <span>→</span></a></article>
                <article class="customer-account-card"><span>PASSENGERS</span><h2>Travel companions</h2><p>Add passenger details when making your next booking.</p><a href="{{ route('account.dashboard') }}">Open My Account <span>→</span></a></article>
                <article class="customer-account-card"><span>WISHLIST</span><h2>Saved experiences</h2><p>Keep the experiences you love ready for your next trip.</p><a href="{{ route('account.wishlist') }}">Open wishlist <span>→</span></a></article>
            </div>
        </div>
    </section>
@endsection
