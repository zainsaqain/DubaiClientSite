@extends('admin.layouts.app')

@section('title', $attraction->exists ? 'Edit Attraction' : 'Create Attraction')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>ATTRACTIONS</p><h1>{{ $attraction->exists ? 'Edit attraction' : 'Create a new attraction' }}</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('admin.attractions.index') }}">← Back to index</a></div></header>
            <form method="POST" enctype="multipart/form-data" action="{{ $attraction->exists ? route('admin.attractions.update', $attraction) : route('admin.attractions.store') }}" class="wmt-admin-form">
                @csrf @if ($attraction->exists) @method('PUT') @endif
                <section class="wmt-admin-panel"><div class="wmt-admin-panel-heading"><div><span>ATTRACTION DETAILS</span><h2>Tell guests what to discover.</h2></div><span class="wmt-form-required">* Required fields</span></div><div class="wmt-form-grid"><label class="wmt-form-wide">Attraction title *<input name="title" value="{{ old('title', $attraction->title) }}" required maxlength="160" placeholder="e.g. Dubai Aquarium & Underwater Zoo"></label><label>Attraction type *<input name="attraction_type" value="{{ old('attraction_type', $attraction->attraction_type) }}" required maxlength="80" placeholder="e.g. Family favourite"></label><label>Location *<input name="location" value="{{ old('location', $attraction->location ?: 'Dubai') }}" required maxlength="100" placeholder="Dubai"></label><label>Starting price (PKR) *<input name="price" type="number" min="0" step="0.01" value="{{ old('price', $attraction->price) }}" required placeholder="8500"></label><label class="wmt-form-wide">Description *<textarea name="description" required maxlength="1200" rows="6" placeholder="Share the attraction highlights...">{{ old('description', $attraction->description) }}</textarea></label><label class="wmt-form-wide">Attraction image <input name="image" type="file" accept="image/*"><small>JPG, PNG or WEBP — maximum 4 MB. A WMT default image is used if blank.</small></label></div>@if ($attraction->exists && $attraction->image)<div class="wmt-form-image-preview"><img src="{{ $attraction->imageUrl() }}" alt="Current attraction"><span>Current image</span></div>@endif<div class="wmt-form-options"><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $attraction->is_featured))><span><strong>Feature this attraction</strong><small>Mark it as a standout experience in your catalogue.</small></span></label><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $attraction->exists ? $attraction->is_active : true))><span><strong>Make it live</strong><small>Visible immediately on the public Attractions page.</small></span></label></div></section>
                @if ($errors->any())<div class="wmt-admin-error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <div class="wmt-form-actions"><a href="{{ route('admin.attractions.index') }}">Cancel</a><button class="wmt-admin-primary-action" type="submit">{{ $attraction->exists ? 'Save changes' : 'Create attraction' }} <span>→</span></button></div>
            </form>
        </main>
    </div>
@endsection
