@extends('admin.layouts.app')

@section('title', $card->exists ? 'Edit Home Promo Card' : 'Create Home Promo Card')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>HOME · PROMO CARDS</p><h1>{{ $card->exists ? 'Edit promo card' : 'Create a promo card' }}</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('admin.home.promo-cards.index') }}">← Back to index</a></div></header>
            <form method="POST" enctype="multipart/form-data" action="{{ $card->exists ? route('admin.home.promo-cards.update', $card) : route('admin.home.promo-cards.store') }}" class="wmt-admin-form">@csrf @if ($card->exists)@method('PUT')@endif
                <section class="wmt-admin-panel"><div class="wmt-admin-panel-heading"><div><span>CARD DETAILS</span><h2>Update this home page feature.</h2></div><span class="wmt-form-required">* Required fields</span></div><div class="wmt-form-grid"><label>Small heading *<input name="eyebrow" value="{{ old('eyebrow', $card->eyebrow) }}" required maxlength="80" placeholder="WMT CURATED"></label><label>Display order *<input name="display_order" type="number" min="1" value="{{ old('display_order', $card->display_order) }}" required></label><label class="wmt-form-wide">Title *<input name="title" value="{{ old('title', $card->title) }}" required maxlength="160" placeholder="Curated City Tours"></label><label class="wmt-form-wide">Description *<textarea name="description" required maxlength="600" rows="5">{{ old('description', $card->description) }}</textarea></label><label>Button text *<input name="button_label" value="{{ old('button_label', $card->button_label) }}" required maxlength="60" placeholder="Learn more"></label><label>Button link *<input name="button_url" value="{{ old('button_url', $card->button_url) }}" required maxlength="255" placeholder="#booking"></label><label class="wmt-form-wide">Card image <input name="image" type="file" accept="image/*"><small>JPG, PNG or WEBP — maximum 5 MB. Keep blank to use the WMT default image.</small></label></div>@if ($card->exists && $card->image)<div class="wmt-form-image-preview"><img src="{{ $card->imageUrl() }}" alt="Current promo card"><span>Current image</span></div>@endif<div class="wmt-form-options"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $card->exists ? $card->is_active : true))><span><strong>Make it live</strong><small>Visible immediately under the home page hero.</small></span></label></div></section>
                @if ($errors->any())<div class="wmt-admin-error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <div class="wmt-form-actions"><a href="{{ route('admin.home.promo-cards.index') }}">Cancel</a><button class="wmt-admin-primary-action" type="submit">{{ $card->exists ? 'Save changes' : 'Create card' }} <span>→</span></button></div>
            </form>
        </main>
    </div>
@endsection
