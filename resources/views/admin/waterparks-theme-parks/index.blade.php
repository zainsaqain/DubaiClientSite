@extends('admin.layouts.app')

@section('title', 'Waterparks & Theme Parks')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar">
                <div><p>CATEGORY MANAGEMENT</p><h1>Waterparks &amp; Theme Parks</h1></div>
                <div class="wmt-admin-actions">
                    <a class="wmt-admin-site-link" href="{{ route('waterparks-theme-parks') }}">View public page <span>↗</span></a>
                    <a class="wmt-admin-primary-action" href="{{ route('admin.waterparks-theme-parks.create') }}">Add park <span>＋</span></a>
                </div>
            </header>

            @if (session('success'))
                <div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div>
            @endif

            <section class="wmt-admin-panel wmt-manager-intro">
                <div><span>WATERPARKS &amp; THEME PARKS</span><h2>Manage every family day out.</h2><p>Create, edit, feature, hide or delete waterpark and theme park experiences. Live records appear on the public page automatically.</p></div>
                <div class="wmt-manager-total"><strong>{{ $parks->total() }}</strong><span>saved experiences</span></div>
            </section>

            <section class="wmt-admin-panel wmt-manager-table-panel">
                <div class="wmt-admin-panel-heading"><div><span>YOUR CATALOGUE</span><h2>All park experiences</h2></div><a href="{{ route('admin.waterparks-theme-parks.create') }}">Create new →</a></div>
                @if ($parks->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your park catalogue is ready.</h3><p>Create your first experience and it will be saved to the database.</p><a class="wmt-admin-primary-action" href="{{ route('admin.waterparks-theme-parks.create') }}">Create experience</a></div>
                @else
                    <div class="wmt-manager-table-wrap">
                        <table class="wmt-manager-table">
                            <thead><tr><th>Experience</th><th>Type</th><th>Price</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead>
                            <tbody>
                                @foreach ($parks as $park)
                                    <tr>
                                        <td class="wmt-manager-name"><img src="{{ $park->imageUrl() }}" alt="" onerror="this.src='{{ asset('images/water-theme-parks-dubai.png') }}'"><span><strong>{{ $park->title }}</strong><small>{{ $park->location }}</small></span></td>
                                        <td><span class="wmt-category-tag">{{ $park->park_type }}</span></td>
                                        <td><strong>PKR {{ number_format((float) $park->price, 0) }}</strong></td>
                                        <td><span class="wmt-admin-status {{ $park->is_active ? 'confirmed' : 'pending' }}">{{ $park->is_active ? 'Live' : 'Hidden' }}</span>@if ($park->is_featured)<small class="wmt-featured-note">Featured</small>@endif</td>
                                        <td><small>{{ $park->updated_at->diffForHumans() }}</small></td>
                                        <td class="wmt-manager-actions"><a href="{{ route('admin.waterparks-theme-parks.edit', $park) }}">Edit</a><form action="{{ route('admin.waterparks-theme-parks.destroy', $park) }}" method="POST" onsubmit="return confirm('Remove this park experience?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($parks->hasPages())
                        <nav class="wmt-admin-pagination" aria-label="Park experience pages">
                            @if ($parks->onFirstPage())
                                <span class="is-disabled">← Previous</span>
                            @else
                                <a href="{{ $parks->previousPageUrl() }}">← Previous</a>
                            @endif
                            <span class="wmt-page-numbers">
                                @foreach ($parks->getUrlRange(1, $parks->lastPage()) as $page => $url)
                                    @if ($page === $parks->currentPage())
                                        <span class="is-current" aria-current="page">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </span>
                            @if ($parks->hasMorePages())
                                <a href="{{ $parks->nextPageUrl() }}">Next →</a>
                            @else
                                <span class="is-disabled">Next →</span>
                            @endif
                        </nav>
                    @endif
                @endif
            </section>
        </main>
    </div>
@endsection
