@extends('admin.layouts.app')

@section('title', $testimonial->exists ? 'Edit Testimonial' : 'Create Testimonial')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>HOME · TESTIMONIALS</p><h1>{{ $testimonial->exists ? 'Edit testimonial' : 'Create testimonial' }}</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('admin.home.testimonials.index') }}">← Back to index</a></div></header>
            <form method="POST" enctype="multipart/form-data" action="{{ $testimonial->exists ? route('admin.home.testimonials.update', $testimonial) : route('admin.home.testimonials.store') }}" class="wmt-admin-form">@csrf @if ($testimonial->exists)@method('PUT')@endif
                <section class="wmt-admin-panel"><div class="wmt-admin-panel-heading"><div><span>GUEST REVIEW</span><h2>Share a memorable guest story.</h2></div><span class="wmt-form-required">* Required fields</span></div><div class="wmt-form-grid"><label>Guest name *<input name="name" value="{{ old('name', $testimonial->name) }}" required maxlength="100"></label><label>Country *<input name="country" value="{{ old('country', $testimonial->country) }}" required maxlength="100"></label><label>Rating *<input name="rating" type="number" min="1" max="5" value="{{ old('rating', $testimonial->rating) }}" required></label><label>Display order *<input name="display_order" type="number" min="1" value="{{ old('display_order', $testimonial->display_order) }}" required></label><label class="wmt-form-wide">Guest review *<textarea name="quote" required maxlength="1200" rows="7">{{ old('quote', $testimonial->quote) }}</textarea></label><label class="wmt-form-wide">Guest photo <input name="avatar" type="file" accept="image/*"><small>JPG, PNG or WEBP — maximum 4 MB.</small></label></div>@if ($testimonial->exists && $testimonial->avatar)<div class="wmt-form-image-preview"><img src="{{ $testimonial->avatarUrl() }}" alt="Current guest"><span>Current image</span></div>@endif<div class="wmt-form-options"><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $testimonial->is_featured))><span><strong>Feature this review</strong><small>Highlights this card with a gold border.</small></span></label><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->exists ? $testimonial->is_active : true))><span><strong>Make it live</strong><small>Visible immediately on the home page.</small></span></label></div></section>
                @if ($errors->any())<div class="wmt-admin-error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <div class="wmt-form-actions"><a href="{{ route('admin.home.testimonials.index') }}">Cancel</a><button class="wmt-admin-primary-action" type="submit">{{ $testimonial->exists ? 'Save changes' : 'Create testimonial' }} <span>→</span></button></div>
            </form>
        </main>
    </div>
@endsection
