@extends('admin.layouts.app')

@section('title', 'Bank Transfer Settings')

@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')
    <main class="wmt-admin-main wmt-admin-manager-main wmt-bank-transfer-page"><header class="wmt-admin-topbar"><div><p>PAYMENTS</p><h1>Bank Transfer Settings</h1></div><span class="wmt-bank-transfer-state {{ $setting->is_enabled ? 'is-active' : '' }}"><i></i>{{ $setting->is_enabled ? 'Active' : 'Disabled' }}</span></header>
        @if(session('success'))<div class="wmt-admin-flash">✓ {{ session('success') }}</div>@endif
        <section class="wmt-admin-panel wmt-bank-transfer-card"><div class="wmt-bank-transfer-card-head"><span class="wmt-bank-transfer-icon">⌁</span><div><span>DIRECT BANK TRANSFER · {{ $setting->is_enabled ? 'ACTIVE' : 'DISABLED' }}</span><h2>Emirates NBD account settings</h2><p>These details are shown to customers only after an order is created. Update or remove the account from this one place.</p></div></div><form id="bank-details-form" method="POST" action="{{ route('admin.bank-transfer-settings.update') }}" class="wmt-admin-form">@csrf @method('PUT')
            <div class="wmt-form-grid"><label>Bank name<input name="bank_name" value="{{ old('bank_name', $setting->bank_name) }}" required></label><label>Account holder name<input name="account_holder_name" value="{{ old('account_holder_name', $setting->account_holder_name) }}" required></label><label class="wmt-form-wide">IBAN<input name="iban" value="{{ old('iban', $setting->iban) }}" required autocomplete="off" spellcheck="false"></label><label>Account number <small>Optional</small><input name="account_number" value="{{ old('account_number', $setting->account_number) }}" autocomplete="off"></label><label>SWIFT / BIC <small>Optional</small><input name="swift_bic" value="{{ old('swift_bic', $setting->swift_bic) }}" autocomplete="off"></label><label>Currency<input name="currency" maxlength="3" value="{{ old('currency', $setting->currency) }}" required></label><label class="wmt-form-wide">Payment instructions<textarea name="payment_instructions" rows="5" placeholder="Tell customers how to make their bank transfer and what reference to use.">{{ old('payment_instructions', $setting->payment_instructions) }}</textarea></label></div>
            <div class="wmt-form-options"><label><input type="checkbox" name="is_enabled" value="1" @checked(old('is_enabled', $setting->is_enabled))><span><strong>Enable Direct Bank Transfer</strong><small>Customers can choose this method at checkout and submit their transaction reference for verification.</small></span></label></div>
            @if($errors->any())<div class="wmt-admin-error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
            <div class="wmt-form-actions"><p>Bank details are shown only after a customer creates an order.</p><button class="wmt-admin-primary-action" type="submit">Save bank details <span>→</span></button></div>
        </form></section>
        @if($setting->exists)<form method="POST" action="{{ route('admin.bank-transfer-settings.destroy') }}" class="wmt-bank-transfer-remove" onsubmit="return confirm('Remove these bank details? Customers will no longer be able to select bank transfer at checkout.')">@csrf @method('DELETE')<div><strong>Remove bank transfer account</strong><p>This disables bank transfer checkout. Existing payment records will be kept.</p></div><button type="submit">Remove details</button></form>@endif
    </main>
</div>
@endsection
