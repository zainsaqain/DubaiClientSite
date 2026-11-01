@extends('admin.layouts.app')

@section('title', $tour->exists ? 'Edit City Tour' : 'Create City Tour')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>CITY TOURS</p><h1>{{ $tour->exists ? 'Edit city tour' : 'Create a new city tour' }}</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('admin.city-tours.index') }}">← Back to index</a></div></header>
            <form method="POST" enctype="multipart/form-data" action="{{ $tour->exists ? route('admin.city-tours.update', $tour) : route('admin.city-tours.store') }}" class="wmt-admin-form">
                @csrf @if ($tour->exists) @method('PUT') @endif
                <section class="wmt-admin-panel"><div class="wmt-admin-panel-heading"><div><span>CITY TOUR DETAILS</span><h2>Tell guests what to discover.</h2></div><span class="wmt-form-required">* Required fields</span></div><div class="wmt-form-grid"><label class="wmt-form-wide">Tour title *<input name="title" value="{{ old('title', $tour->title) }}" required maxlength="160" placeholder="e.g. Dubai Full Day Tour"></label><label>Tour type *<input name="tour_type" value="{{ old('tour_type', $tour->tour_type) }}" required maxlength="80" placeholder="e.g. Full day"></label><label>Location *<input name="location" value="{{ old('location', $tour->location ?: 'Dubai') }}" required maxlength="100" placeholder="Dubai"></label><label>Starting price (PKR) *<input name="price" type="number" min="0" step="0.01" value="{{ old('price', $tour->price) }}" required placeholder="18000"></label><label class="wmt-form-wide">Description *<textarea name="description" required maxlength="1200" rows="6" placeholder="Share the city tour highlights...">{{ old('description', $tour->description) }}</textarea></label><label class="wmt-form-wide">Tour image <input name="image" type="file" accept="image/*"><small>JPG, PNG or WEBP — maximum 4 MB. A WMT default image is used if blank.</small></label></div>@if ($tour->exists && $tour->image)<div class="wmt-form-image-preview"><img src="{{ $tour->imageUrl() }}" alt="Current city tour"><span>Current image</span></div>@endif<div class="wmt-form-options"><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $tour->is_featured))><span><strong>Feature this city tour</strong><small>Mark it as a standout experience in your catalogue.</small></span></label><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $tour->exists ? $tour->is_active : true))><span><strong>Make it live</strong><small>Visible immediately on the public City Tours page.</small></span></label></div></section>
                @if ($errors->any())<div class="wmt-admin-error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <div class="wmt-form-actions"><a href="{{ route('admin.city-tours.index') }}">Cancel</a><button class="wmt-admin-primary-action" type="submit">{{ $tour->exists ? 'Save changes' : 'Create city tour' }} <span>→</span></button></div>
            </form>
        </main>
    </div>
@endsection
