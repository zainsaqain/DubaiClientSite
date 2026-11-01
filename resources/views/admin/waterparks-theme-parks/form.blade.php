@extends('admin.layouts.app')

@section('title', $park->exists ? 'Edit Park Experience' : 'Create Park Experience')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>WATERPARKS &amp; THEME PARKS</p><h1>{{ $park->exists ? 'Edit park experience' : 'Create a new park experience' }}</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('admin.waterparks-theme-parks.index') }}">← Back to index</a></div></header>
            <form method="POST" enctype="multipart/form-data" action="{{ $park->exists ? route('admin.waterparks-theme-parks.update', $park) : route('admin.waterparks-theme-parks.store') }}" class="wmt-admin-form">
                @csrf
                @if ($park->exists)
                    @method('PUT')
                @endif
                <section class="wmt-admin-panel">
                    <div class="wmt-admin-panel-heading"><div><span>EXPERIENCE DETAILS</span><h2>Tell guests where the fun begins.</h2></div><span class="wmt-form-required">* Required fields</span></div>
                    <div class="wmt-form-grid">
                        <label class="wmt-form-wide">Experience title *<input name="title" value="{{ old('title', $park->title) }}" required maxlength="160" placeholder="e.g. Atlantis Aquaventure"></label>
                        <label>Experience type *<input name="park_type" value="{{ old('park_type', $park->park_type) }}" required maxlength="80" placeholder="e.g. Waterpark"></label>
                        <label>Location *<input name="location" value="{{ old('location', $park->location ?: 'Dubai') }}" required maxlength="100" placeholder="Dubai"></label>
                        <label>Starting price (PKR) *<input name="price" type="number" min="0" step="0.01" value="{{ old('price', $park->price) }}" required placeholder="19999"></label>
                        <label class="wmt-form-wide">Description *<textarea name="description" required maxlength="1200" rows="6" placeholder="Share the experience highlights...">{{ old('description', $park->description) }}</textarea></label>
                        <label class="wmt-form-wide">Experience image <input name="image" type="file" accept="image/*"><small>JPG, PNG or WEBP — maximum 4 MB. A WMT default image is used if blank.</small></label>
                    </div>
                    @if ($park->exists && $park->image)
                        <div class="wmt-form-image-preview"><img src="{{ $park->imageUrl() }}" alt="Current experience"><span>Current image</span></div>
                    @endif
                    <div class="wmt-form-options">
                        <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $park->is_featured))><span><strong>Feature this experience</strong><small>Mark it as a standout family day out in your catalogue.</small></span></label>
                        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $park->exists ? $park->is_active : true))><span><strong>Make it live</strong><small>Visible immediately on the public Waterparks &amp; Theme Parks page.</small></span></label>
                    </div>
                </section>
                @if ($errors->any())<div class="wmt-admin-error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <div class="wmt-form-actions"><a href="{{ route('admin.waterparks-theme-parks.index') }}">Cancel</a><button class="wmt-admin-primary-action" type="submit">{{ $park->exists ? 'Save changes' : 'Create experience' }} <span>→</span></button></div>
            </form>
        </main>
    </div>
@endsection
