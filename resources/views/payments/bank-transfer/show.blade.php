@extends('layouts.site')

@section('title', 'Bank Transfer Payment | Waheed Murad Tourism')

@section('content')
<section class="wmt-payment-page da-container">
    <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Order '.$booking->order_number]]" />
    <header class="wmt-payment-hero"><div><span>DIRECT BANK TRANSFER</span><h1>Order {{ $booking->order_number }}</h1><p>{{ $booking->tour->name }} · Travel date {{ $booking->travel_date->format('d M Y') }}</p></div><div class="wmt-payment-amount"><span>AMOUNT DUE</span><strong>{{ $booking->currency }} {{ number_format((float) $booking->amount, 2) }}</strong><small>{{ ucwords(str_replace('_', ' ', $booking->payment_status)) }}</small></div></header>
    @if(session('success'))<p class="wmt-payment-success">✓ {{ session('success') }}</p>@endif
    <div class="wmt-payment-detail-layout">
        <main class="wmt-payment-card">
        @if($booking->bankTransferPayment->status === 'paid')
            <div class="wmt-payment-confirmed"><span>✓</span><div><h2>Payment verified</h2><p>Your booking is confirmed. Keep your order number for future reference.</p></div></div>
        @else
            <div class="wmt-bank-details"><div class="wmt-bank-details-head"><span>⌁</span><div><small>TRANSFER TO</small><h2>{{ $setting->bank_name }}</h2></div><b>{{ $setting->currency }}</b></div><dl><div><dt>Account holder</dt><dd>{{ $setting->account_holder_name }}</dd></div><div class="wmt-bank-iban"><dt>IBAN</dt><dd id="iban">{{ $setting->iban }}</dd><button type="button" onclick="navigator.clipboard.writeText(document.getElementById('iban').textContent.trim());this.textContent='Copied'">Copy IBAN</button></div>@if($setting->account_number)<div><dt>Account number</dt><dd>{{ $setting->account_number }}</dd></div>@endif @if($setting->swift_bic)<div><dt>SWIFT / BIC</dt><dd>{{ $setting->swift_bic }}</dd></div>@endif</dl><div class="wmt-bank-instructions"><strong>Before you submit</strong><p>{!! nl2br(e($setting->payment_instructions ?: 'Transfer the exact amount using your order number as the payment reference. Then submit your bank transaction reference below.')) !!}</p></div>
            </div>
            @if($booking->bankTransferPayment->status === 'pending_verification')
                <p class="wmt-payment-info">Your payment details are awaiting verification. We will process your order once the funds are confirmed.</p>
            @else
                @if($booking->bankTransferPayment->rejection_reason)<p class="wmt-payment-error">Admin note: {{ $booking->bankTransferPayment->rejection_reason }}</p>@endif
                <form method="POST" action="{{ route('bank-transfer.submit', $booking) }}" enctype="multipart/form-data" class="wmt-payment-form wmt-payment-submit-form">
                    @csrf
                    <div class="wmt-payment-form-intro"><span>PAYMENT CONFIRMATION</span><h2>Submit your transfer details</h2><p>We will never mark your order as paid until an administrator verifies the transfer.</p></div>
                    <label>Order ID<input value="{{ $booking->order_number }}" readonly></label><label>Payment amount<input value="{{ $booking->currency }} {{ number_format((float) $booking->amount, 2) }}" readonly></label>
                    <label class="wmt-payment-wide">Transaction reference number<input name="transaction_reference" value="{{ old('transaction_reference', $booking->bankTransferPayment->transaction_reference) }}" required maxlength="120"></label><label>Payment date <small>Optional</small><input name="payment_date" type="date" max="{{ now()->toDateString() }}" value="{{ old('payment_date', optional($booking->bankTransferPayment->payment_date)->format('Y-m-d')) }}"></label><label>Payment screenshot <small>Optional · JPG, PNG or WebP · max 5 MB</small><input name="screenshot" type="file" accept="image/jpeg,image/png,image/webp"></label>
                    @if($booking->bankTransferPayment->screenshot_path)<a class="wmt-payment-file-link" href="{{ route('bank-transfer.screenshot', $booking) }}">View previously submitted screenshot →</a>@endif
                    @if($errors->any())<div class="wmt-payment-error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
                    <button class="wmt-payment-submit" type="submit">Submit payment details <span>→</span></button>
                </form>
            @endif
        @endif
        </main>
        <aside class="wmt-payment-help"><span>⌂</span><h2>Payment checklist</h2><ol><li>Transfer the exact amount.</li><li>Use the order number as reference.</li><li>Submit your transaction reference.</li><li>Wait for manual verification.</li></ol><p>Payments are never auto-approved from a screenshot.</p></aside>
    </div>
</section>
@endsection
