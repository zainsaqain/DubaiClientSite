@extends('admin.layouts.app')

@section('title', $adventure->exists ? 'Edit Desert Adventure' : 'Create Desert Adventure')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')

        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar">
                <div><p>DESERT ADVENTURES</p><h1>{{ $adventure->exists ? 'Edit adventure' : 'Create a new adventure' }}</h1></div>
                <div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('admin.desert-adventures.index') }}">← Back to index</a></div>
            </header>

            <form method="POST" enctype="multipart/form-data" action="{{ $adventure->exists ? route('admin.desert-adventures.update', $adventure) : route('admin.desert-adventures.store') }}" class="wmt-admin-form">
                @csrf
                @if ($adventure->exists) @method('PUT') @endif
                <section class="wmt-admin-panel">
                    <div class="wmt-admin-panel-heading"><div><span>EXPERIENCE DETAILS</span><h2>Tell guests what awaits.</h2></div><span class="wmt-form-required">* Required fields</span></div>
                    <div class="wmt-form-grid">
                        <label class="wmt-form-wide">Experience title *<input name="title" value="{{ old('title', $adventure->title) }}" required maxlength="160" placeholder="e.g. Sunset Desert Safari"></label>
                        <label>Category *<select name="category" required>@foreach (['Desert Safaris', 'Desert Experiences', 'Dune Buggies', 'School Trips'] as $category)<option value="{{ $category }}" @selected(old('category', $adventure->category ?: 'Desert Safaris') === $category)>{{ $category }}</option>@endforeach</select></label>
                        <label>Location *<input name="location" value="{{ old('location', $adventure->location ?: 'Dubai') }}" required maxlength="100" placeholder="Dubai"></label>
                        <label>Starting price (AED) *<input name="price" type="number" min="0" step="0.01" value="{{ old('price', $adventure->price) }}" required placeholder="250"></label>
                        <label>Duration <input name="duration" value="{{ old('duration', $adventure->duration) }}" maxlength="80" placeholder="e.g. 6 hours"></label>
                        <label class="wmt-form-wide">Description *<textarea name="description" required maxlength="1200" rows="6" placeholder="Share the highlights of this adventure...">{{ old('description', $adventure->description) }}</textarea></label>
                        <label class="wmt-form-wide">Experience image <input name="image" type="file" accept="image/*"><small>JPG, PNG or WEBP — maximum 4 MB. A WMT default image is used if blank.</small></label>
                    </div>
                    @if ($adventure->exists && $adventure->image)
                        <div class="wmt-form-image-preview"><img src="{{ $adventure->imageUrl() }}" alt="Current adventure"><span>Current image</span></div>
                    @endif
                    <div class="wmt-form-options"><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $adventure->is_featured))><span><strong>Feature this adventure</strong><small>Show it as a bestseller on the public listing.</small></span></label><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $adventure->exists ? $adventure->is_active : true))><span><strong>Make it live</strong><small>Visible immediately on the category listing and its matching detail page.</small></span></label></div>
                </section>

                @if ($errors->any())<div class="wmt-admin-error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

                <div class="wmt-form-actions"><a href="{{ route('admin.desert-adventures.index') }}">Cancel</a><button class="wmt-admin-primary-action" type="submit">{{ $adventure->exists ? 'Save changes' : 'Create adventure' }} <span>→</span></button></div>
            </form>
        </main>
    </div>
@endsection
