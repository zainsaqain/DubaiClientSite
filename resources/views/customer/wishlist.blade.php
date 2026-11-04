@extends('layouts.site')

@section('title', 'Wishlist | Waheed Murad Tourism')

@section('content')
    <section class="customer-account-page"><div class="customer-account-container"><x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'My Account', 'url' => route('account.dashboard')], ['label' => 'Wishlist']]" /><header class="customer-account-heading"><span>SAVED FOR LATER</span><h1>My Wishlist</h1><p>Your favourite Dubai experiences live here.</p></header>@include('customer.partials.navigation')<section class="customer-empty-state"><span>♡</span><h2>Your wishlist is empty</h2><p>Tap the heart on any experience to save it for your next Dubai trip.</p><a href="{{ route('home') }}#experiences">Browse experiences <b>→</b></a></section></div></section>
@endsection
