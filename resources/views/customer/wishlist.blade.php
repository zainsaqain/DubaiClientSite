@extends('layouts.site')

@section('title', 'Wishlist | Waheed Murad Tourism')

@section('content')
    <section class="customer-account-page">
        <div class="customer-account-container">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'My Account', 'url' => route('account.dashboard')], ['label' => 'Wishlist']]" />
            <header class="customer-account-heading">
                <span>SAVED FOR LATER</span>
                <h1>My Wishlist</h1>
                <p>Your favourite Dubai experiences live here.</p>
            </header>

            @include('customer.partials.navigation')

            @if (session('wishlist-status'))
                <p class="customer-account-alert">{{ session('wishlist-status') }}</p>
            @endif

            @if ($wishlists->isNotEmpty())
                <section class="customer-wishlist-grid" aria-label="Saved experiences">
                    @foreach ($wishlists as $wishlist)
                        @php($tour = $wishlist->tour)
                        @if ($tour)
                            <article class="customer-wishlist-card">
                                <a class="customer-wishlist-image" href="{{ route('tours.show', $tour) }}">
                                    <img src="{{ $tour->imageUrl() }}" alt="{{ $tour->image_alt ?: $tour->name }}">
                                </a>
                                <div class="customer-wishlist-copy">
                                    <span>{{ $tour->subcategory?->name ?? $tour->category?->name ?? 'Experience' }}</span>
                                    <h2><a href="{{ route('tours.show', $tour) }}">{{ $tour->name }}</a></h2>
                                    <p>{{ $tour->location }} · From {{ $tour->currency }} {{ number_format((float) $tour->starting_price) }}</p>
                                    <div>
                                        <a href="{{ route('tours.show', $tour) }}">View tour <b>→</b></a>
                                        <form method="POST" action="{{ route('tours.wishlist.destroy', $tour) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </section>
            @else
                <section class="customer-empty-state">
                    <span>♡</span>
                    <h2>Your wishlist is empty</h2>
                    <p>Tap the heart on any experience to save it for your next Dubai trip.</p>
                    <a href="{{ route('home') }}#experiences">Browse experiences <b>→</b></a>
                </section>
            @endif
        </div>
    </section>
@endsection
