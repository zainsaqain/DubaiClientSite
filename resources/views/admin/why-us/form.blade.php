@extends('admin.layouts.app')

@section('title', $feature->exists ? 'Edit Why Us Section' : 'Create Why Us Section')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>WHY US</p><h1>{{ $feature->exists ? 'Edit Why Us section' : 'Create a Why Us section' }}</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('admin.why-us.index') }}">← Back to index</a></div></header>
            <form method="POST" enctype="multipart/form-data" action="{{ $feature->exists ? route('admin.why-us.update', $feature) : route('admin.why-us.store') }}" class="wmt-admin-form">
                @csrf
                @if ($feature->exists)@method('PUT')@endif
                <section class="wmt-admin-panel"><div class="wmt-admin-panel-heading"><div><span>SECTION DETAILS</span><h2>Tell guests why to choose WMT.</h2></div><span class="wmt-form-required">* Required fields</span></div><div class="wmt-form-grid"><label>Small heading *<input name="eyebrow" value="{{ old('eyebrow', $feature->eyebrow) }}" required maxlength="100" placeholder="e.g. TRAVEL WITH CARE"></label><label>Display order *<input name="display_order" type="number" min="1" max="999" value="{{ old('display_order', $feature->display_order) }}" required></label><label class="wmt-form-wide">Section title *<input name="title" value="{{ old('title', $feature->title) }}" required maxlength="160" placeholder="e.g. Nature First"></label><label class="wmt-form-wide">Description *<textarea name="description" required maxlength="1800" rows="7" placeholder="Share the story behind this section...">{{ old('description', $feature->description) }}</textarea></label><label>Button text <input name="link_label" value="{{ old('link_label', $feature->link_label) }}" maxlength="100" placeholder="e.g. Discover city tours"></label><label>Button link <input name="link_url" value="{{ old('link_url', $feature->link_url) }}" maxlength="255" placeholder="e.g. /city-tours"></label><label class="wmt-form-wide">Section image <input name="image" type="file" accept="image/*"><small>JPG, PNG or WEBP — maximum 4 MB. Keep blank to use the WMT default image.</small></label></div>@if ($feature->exists && $feature->image)<div class="wmt-form-image-preview"><img src="{{ $feature->imageUrl() }}" alt="Current section"><span>Current image</span></div>@endif<div class="wmt-form-options"><label><input type="checkbox" name="is_reversed" value="1" @checked(old('is_reversed', $feature->is_reversed))><span><strong>Put image on the right</strong><small>Alternates the row layout for a more visual page.</small></span></label><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $feature->exists ? $feature->is_active : true))><span><strong>Make it live</strong><small>Visible immediately on the public Why Us page.</small></span></label></div></section>
                @if ($errors->any())<div class="wmt-admin-error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <div class="wmt-form-actions"><a href="{{ route('admin.why-us.index') }}">Cancel</a><button class="wmt-admin-primary-action" type="submit">{{ $feature->exists ? 'Save changes' : 'Create section' }} <span>→</span></button></div>
            </form>
        </main>
    </div>
@endsection
