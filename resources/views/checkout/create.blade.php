@extends('layouts.site')

@section('title', 'Secure Checkout | Waheed Murad Tourism')

@section('content')
<section class="wmt-payment-page da-container">
    <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => $tour->name, 'url' => route('tours.show', $tour)], ['label' => 'Checkout']]" />
    <header class="wmt-payment-hero"><div><span>SECURE CHECKOUT</span><h1>Complete your booking</h1><p>Review your travel details, then pay securely by manual bank transfer.</p></div><ol><li class="is-current"><b>1</b> Booking</li><li><b>2</b> Transfer</li><li><b>3</b> Verification</li></ol></header>
    <div class="wmt-checkout-layout">
        <main class="wmt-payment-card">
            <div class="wmt-payment-card-heading"><span class="wmt-payment-card-icon">✦</span><div><h2>{{ $tour->name }}</h2><p>{{ $tour->location }} · From {{ $tour->currency }} {{ number_format((float) $tour->starting_price, 2) }}</p></div></div>
        @if(! $bankTransferEnabled)
            <p class="wmt-payment-alert">Direct Bank Transfer is temporarily unavailable. Please contact us for help.</p>
        @else
            <form method="POST" action="{{ route('checkout.store', $tour) }}" class="wmt-payment-form">
                @csrf
                <div class="wmt-payment-form-intro"><span>TRAVEL DETAILS</span><p>Prices are confirmed using the selected tour option and traveller count.</p></div>
                <label class="wmt-payment-wide">Travel date<input name="travel_date" type="date" min="{{ now()->toDateString() }}" value="{{ old('travel_date') }}" required></label>
                @if($tour->prices->where('is_active', true)->isNotEmpty())
                    <label class="wmt-payment-wide">Tour option<select name="tour_price_id">@foreach($tour->prices->where('is_active', true) as $price)<option value="{{ $price->id }}" @selected(old('tour_price_id') == $price->id)>{{ $price->vehicle_label ?: ucfirst($price->vehicle_type) }} — {{ $price->currency }} {{ number_format((float)$price->adult_price, 2) }} per adult</option>@endforeach</select></label>
                @endif
                <div class="wmt-payment-travellers"><label>Adults <small>Age 12+</small><input name="adults" type="number" min="1" max="50" value="{{ old('adults', 1) }}" required></label><label>Children <small>Ages 5–11</small><input name="children" type="number" min="0" max="50" value="{{ old('children', 0) }}"></label><label>Infants <small>Under 5</small><input name="infants" type="number" min="0" max="50" value="{{ old('infants', 0) }}"></label></div>
                <div class="wmt-payment-method"><span>⌁</span><div><strong>Direct Bank Transfer</strong><p>Emirates NBD · Your payment remains pending until bank verification.</p></div><b>Selected</b><input type="hidden" name="payment_method" value="direct_bank_transfer"></div>
                @if($errors->any())<div class="wmt-payment-error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
                <button class="wmt-payment-submit" type="submit">Create secure order <span>→</span></button>
            </form>
        @endif
        </main>
        <aside class="wmt-payment-help"><span>✦</span><h2>Need assistance?</h2><p>Our travel team can help with your booking, group size, or payment details.</p><a href="https://wa.me/971502299598" target="_blank" rel="noopener">Chat on WhatsApp →</a></aside>
    </div>
</section>
@endsection
