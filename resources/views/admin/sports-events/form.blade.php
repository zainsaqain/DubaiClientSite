@extends('admin.layouts.app')

@section('title', $event->exists ? 'Edit Sports Event' : 'Create Sports Event')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')

        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar">
                <div><p>SPORTS EVENTS</p><h1>{{ $event->exists ? 'Edit event' : 'Create a new event' }}</h1></div>
                <div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('admin.sports-events.index') }}">← Back to index</a></div>
            </header>

            <form method="POST" enctype="multipart/form-data" action="{{ $event->exists ? route('admin.sports-events.update', $event) : route('admin.sports-events.store') }}" class="wmt-admin-form">
                @csrf
                @if ($event->exists) @method('PUT') @endif
                <section class="wmt-admin-panel">
                    <div class="wmt-admin-panel-heading"><div><span>EVENT DETAILS</span><h2>Tell guests what is happening.</h2></div><span class="wmt-form-required">* Required fields</span></div>
                    <div class="wmt-form-grid">
                        <label class="wmt-form-wide">Event title *<input name="title" value="{{ old('title', $event->title) }}" required maxlength="160" placeholder="e.g. Dubai Championship Golf Day"></label>
                        <label>Event type *<input name="event_type" value="{{ old('event_type', $event->event_type) }}" required maxlength="80" placeholder="e.g. Golf"></label>
                        <label>Location *<input name="location" value="{{ old('location', $event->location ?: 'Dubai') }}" required maxlength="100" placeholder="Dubai"></label>
                        <label>Starting price (PKR) *<input name="price" type="number" min="0" step="0.01" value="{{ old('price', $event->price) }}" required placeholder="25000"></label>
                        <label class="wmt-form-wide">Description *<textarea name="description" required maxlength="1200" rows="6" placeholder="Share the event highlights...">{{ old('description', $event->description) }}</textarea></label>
                        <label class="wmt-form-wide">Event image <input name="image" type="file" accept="image/*"><small>JPG, PNG or WEBP — maximum 4 MB. A WMT default image is used if blank.</small></label>
                    </div>
                    @if ($event->exists && $event->image)
                        <div class="wmt-form-image-preview"><img src="{{ $event->imageUrl() }}" alt="Current sports event"><span>Current image</span></div>
                    @endif
                    <div class="wmt-form-options"><label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $event->is_featured))><span><strong>Feature this event</strong><small>Mark it as a standout event in your catalogue.</small></span></label><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $event->exists ? $event->is_active : true))><span><strong>Make it live</strong><small>Visible immediately on the public Sports Events page.</small></span></label></div>
                </section>

                @if ($errors->any())<div class="wmt-admin-error"><strong>Please check the form:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

                <div class="wmt-form-actions"><a href="{{ route('admin.sports-events.index') }}">Cancel</a><button class="wmt-admin-primary-action" type="submit">{{ $event->exists ? 'Save changes' : 'Create event' }} <span>→</span></button></div>
            </form>
        </main>
    </div>
@endsection
