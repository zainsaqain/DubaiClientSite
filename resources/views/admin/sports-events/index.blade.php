@extends('admin.layouts.app')

@section('title', 'Sports Events')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')

        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar">
                <div><p>CATEGORY MANAGEMENT</p><h1>Sports Events</h1></div>
                <div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('sports-events') }}">View public page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.sports-events.create') }}">Add event <span>＋</span></a></div>
            </header>

            @if (session('success'))
                <div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div>
            @endif

            <section class="wmt-admin-panel wmt-manager-intro">
                <div><span>SPORTS EVENTS</span><h2>Manage your live events.</h2><p>Create, edit, feature, hide or delete sports events. Every live event appears on the public Sports Events page automatically.</p></div>
                <div class="wmt-manager-total"><strong>{{ $events->total() }}</strong><span>saved events</span></div>
            </section>

            <section class="wmt-admin-panel wmt-manager-table-panel">
                <div class="wmt-admin-panel-heading"><div><span>YOUR CATALOGUE</span><h2>All sports events</h2></div><a href="{{ route('admin.sports-events.create') }}">Create new →</a></div>
                @if ($events->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your events catalogue is ready.</h3><p>Create your first sports event and it will be saved to the database.</p><a class="wmt-admin-primary-action" href="{{ route('admin.sports-events.create') }}">Create event</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Event</th><th>Type</th><th>Price</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td class="wmt-manager-name"><img src="{{ $event->imageUrl() }}" alt="" onerror="this.src='{{ asset('images/sports-events-dubai.png') }}'"><span><strong>{{ $event->title }}</strong><small>{{ $event->location }}</small></span></td>
                                <td><span class="wmt-category-tag">{{ $event->event_type }}</span></td>
                                <td><strong>PKR {{ number_format((float) $event->price, 0) }}</strong></td>
                                <td><span class="wmt-admin-status {{ $event->is_active ? 'confirmed' : 'pending' }}">{{ $event->is_active ? 'Live' : 'Hidden' }}</span>@if ($event->is_featured)<small class="wmt-featured-note">Featured</small>@endif</td>
                                <td><small>{{ $event->updated_at->diffForHumans() }}</small></td>
                                <td class="wmt-manager-actions"><a href="{{ route('admin.sports-events.edit', $event) }}">Edit</a><form action="{{ route('admin.sports-events.destroy', $event) }}" method="POST" onsubmit="return confirm('Remove this sports event?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td>
                            </tr>
                        @endforeach
                    </tbody></table></div>
                    @if ($events->hasPages())
                        <nav class="wmt-admin-pagination" aria-label="Sports event pages">
                            @if ($events->onFirstPage()) <span class="is-disabled">← Previous</span> @else <a href="{{ $events->previousPageUrl() }}">← Previous</a> @endif
                            <span class="wmt-page-numbers">@foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url) @if ($page === $events->currentPage()) <span class="is-current" aria-current="page">{{ $page }}</span> @else <a href="{{ $url }}">{{ $page }}</a> @endif @endforeach</span>
                            @if ($events->hasMorePages()) <a href="{{ $events->nextPageUrl() }}">Next →</a> @else <span class="is-disabled">Next →</span> @endif
                        </nav>
                    @endif
                @endif
            </section>
        </main>
    </div>
@endsection
