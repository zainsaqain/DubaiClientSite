@extends('layouts.site')

@section('title', 'Your Cart | Waheed Murad Tourism')

@section('content')
    <section class="cart-page">
        <div class="cart-container">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Your Cart']]" />
            <header class="cart-heading"><span>YOUR TRIP</span><h1>Your cart</h1><p>Review your selected experiences before you complete your booking.</p></header>

            @if (session('cart-status'))
                <p class="cart-alert">{{ session('cart-status') }}</p>
            @endif

            @if ($items->isNotEmpty())
                <div class="cart-layout">
                    <section class="cart-items" aria-label="Cart items">
                        @foreach ($items as $item)
                            <article class="cart-item">
                                <img src="{{ $item['tour']->imageUrl() }}" alt="{{ $item['tour']->image_alt ?: $item['tour']->name }}">
                                <div class="cart-item-copy">
                                    <span>{{ $item['tour']->subcategory?->name ?? $item['tour']->category?->name ?? 'Experience' }}</span>
                                    <h2>{{ $item['tour']->name }}</h2>
                                    <p>{{ \Illuminate\Support\Carbon::parse($item['travel_date'])->format('d M Y') }} · {{ $item['adults'] }} adult{{ $item['adults'] === 1 ? '' : 's' }}@if ($item['children']) · {{ $item['children'] }} child{{ $item['children'] === 1 ? '' : 'ren' }}@endif @if ($item['infants']) · {{ $item['infants'] }} infant{{ $item['infants'] === 1 ? '' : 's' }}@endif</p>
                                    <a href="{{ route('tours.show', $item['tour']) }}">Edit selection</a>
                                </div>
                                <div class="cart-item-price"><strong>{{ $item['currency'] }} {{ number_format((float) $item['amount'], 2) }}</strong><form method="POST" action="{{ route('cart.destroy', $item['line_id']) }}">@csrf @method('DELETE')<button type="submit">Remove</button></form></div>
                            </article>
                        @endforeach
                    </section>

                    <aside class="cart-summary">
                        <span>ORDER SUMMARY</span><h2>{{ $items->count() }} experience{{ $items->count() === 1 ? '' : 's' }}</h2>
                        <div>
                            <p>Estimated total</p>
                            @foreach ($cartTotals as $currency => $total)
                                <strong>{{ $currency }} {{ number_format($total, 2) }}</strong>
                            @endforeach
                        </div>
                        <p class="cart-summary-note">Your final payment is confirmed securely through direct bank transfer.</p>
                        <a href="{{ route('tours.show', $items->first()['tour']) }}">Continue to booking <span>→</span></a>
                    </aside>
                </div>
            @else
                <section class="cart-empty"><span>⌑</span><h2>Your cart is empty</h2><p>Choose an experience and add it to your cart to start planning your Dubai trip.</p><a href="{{ route('home') }}#experiences">Explore experiences <b>→</b></a></section>
            @endif
        </div>
    </section>
@endsection
