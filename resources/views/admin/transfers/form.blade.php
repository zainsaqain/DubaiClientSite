@extends('admin.layouts.app')

@section('title', $transfer->exists ? 'Edit Transfer' : 'Create Transfer')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>TRANSFERS</p><h1>{{ $transfer->exists ? 'Edit transfer' : 'Create a new transfer' }}</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('admin.transfers.index') }}">← Back to index</a></div></header>
            <form method="POST" enctype="multipart/form-data" action="{{ $transfer->exists ? route('admin.transfers.update', $transfer) : route('admin.transfers.store') }}" class="wmt-admin-form">
                @csrf
                @if ($transfer->exists)@method('PUT')@endif
                <section class="wmt-admin-panel"><div class="wmt-admin-panel-heading"><div><span>TRANSFER DETAILS</span><h2>Tell guests about this journey.</h2></div><span class="wmt-form-required">* Required fields</span></div><div class="wmt-form-grid"><label class="wmt-form-wide">Transfer title *<input name="title" value="{{ old('title', $transfer->title) }}" required maxlength="160" placeholder="e.g. Dubai Airport Private Transfer"></label><label>Transfer type *<input name="transfer_type" value="{{ old('transfer_type', $transfer->transfer_type) }}" required maxlength="80" placeholder="e.g. Airport service"></label><label>Location *<input name="location" value="{{ old('location', $transfer->location ?: 'Dubai & UAE') }}" required maxlength="100" placeholder="Dubai & UAE"></label><label>Starting price (PKR) *<input name="price" type="number" min="0" step="0.01" value="{{ old('price', $transfer->price) }}" required placeholder="9500"></label><label class="wmt-form-wide">Description *<textarea name="description" required maxlength="1200" rows="6" placeholder="Share the transfer highlights...">{{ old('description', $transfer->description) }}</textarea></label><label class="wmt-form-wide">Transfer image <input name="image" type="file" accept="image/*"><small>JPG, PNG or WEBP — maximum 4 MB. A WMT default image is used if blank.</small></label></div>@if ($transfer->exists && $transfer->image)<div class="wmt-form-image-preview"><img src="{{ $transfer->imageUrl() }}" alt="Current transfer"><span>Current image</span></div>@endif<div class="wmt-form-options"><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $transfer->is_featured))><span><strong>Feature this transfer</strong><small>Mark it as a standout journey in your catalogue.</small></span></label><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $transfer->exists ? $transfer->is_active : true))><span><strong>Make it live</strong><small>Visible immediately on the public Transfers page.</small></span></label></div></section>
                @if ($errors->any())<div class="wmt-admin-error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <div class="wmt-form-actions"><a href="{{ route('admin.transfers.index') }}">Cancel</a><button class="wmt-admin-primary-action" type="submit">{{ $transfer->exists ? 'Save changes' : 'Create transfer' }} <span>→</span></button></div>
            </form>
        </main>
    </div>
@endsection
