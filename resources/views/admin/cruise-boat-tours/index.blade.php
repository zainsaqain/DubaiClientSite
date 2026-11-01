@extends('admin.layouts.app')

@section('title', 'Cruise & Boat Tours')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')

        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar">
                <div><p>CATEGORY MANAGEMENT</p><h1>Cruise &amp; Boat Tours</h1></div>
                <div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('cruise-boat-tours') }}">View public page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.cruise-boat-tours.create') }}">Add tour <span>＋</span></a></div>
            </header>

            @if (session('success')) <div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div> @endif

            <section class="wmt-admin-panel wmt-manager-intro">
                <div><span>CRUISE &amp; BOAT TOURS</span><h2>Manage your water experiences.</h2><p>Create, edit, feature, hide or delete every live cruise and boat tour. Active entries appear on the public page automatically.</p></div>
                <div class="wmt-manager-total"><strong>{{ $tours->total() }}</strong><span>saved tours</span></div>
            </section>

            <section class="wmt-admin-panel wmt-manager-table-panel">
                <div class="wmt-admin-panel-heading"><div><span>YOUR CATALOGUE</span><h2>All cruise &amp; boat tours</h2></div><a href="{{ route('admin.cruise-boat-tours.create') }}">Create new →</a></div>
                @if ($tours->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your tours catalogue is ready.</h3><p>Create your first cruise or boat tour and it will be saved to the database.</p><a class="wmt-admin-primary-action" href="{{ route('admin.cruise-boat-tours.create') }}">Create tour</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Tour</th><th>Type</th><th>Price</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>
                        @foreach ($tours as $tour)
                            <tr>
                                <td class="wmt-manager-name"><img src="{{ $tour->imageUrl() }}" alt="" onerror="this.src='{{ asset('images/cruise-dubai-marina.png') }}'"><span><strong>{{ $tour->title }}</strong><small>{{ $tour->location }}</small></span></td>
                                <td><span class="wmt-category-tag">{{ $tour->tour_type }}</span></td>
                                <td><strong>PKR {{ number_format((float) $tour->price, 0) }}</strong></td>
                                <td><span class="wmt-admin-status {{ $tour->is_active ? 'confirmed' : 'pending' }}">{{ $tour->is_active ? 'Live' : 'Hidden' }}</span>@if ($tour->is_featured)<small class="wmt-featured-note">Featured</small>@endif</td>
                                <td><small>{{ $tour->updated_at->diffForHumans() }}</small></td>
                                <td class="wmt-manager-actions"><a href="{{ route('admin.cruise-boat-tours.edit', $tour) }}">Edit</a><form action="{{ route('admin.cruise-boat-tours.destroy', $tour) }}" method="POST" onsubmit="return confirm('Remove this cruise or boat tour?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td>
                            </tr>
                        @endforeach
                    </tbody></table></div>
                    @if ($tours->hasPages())
                        <nav class="wmt-admin-pagination" aria-label="Cruise and boat tour pages">
                            @if ($tours->onFirstPage()) <span class="is-disabled">← Previous</span> @else <a href="{{ $tours->previousPageUrl() }}">← Previous</a> @endif
                            <span class="wmt-page-numbers">@foreach ($tours->getUrlRange(1, $tours->lastPage()) as $page => $url) @if ($page === $tours->currentPage()) <span class="is-current" aria-current="page">{{ $page }}</span> @else <a href="{{ $url }}">{{ $page }}</a> @endif @endforeach</span>
                            @if ($tours->hasMorePages()) <a href="{{ $tours->nextPageUrl() }}">Next →</a> @else <span class="is-disabled">Next →</span> @endif
                        </nav>
                    @endif
                @endif
            </section>
        </main>
    </div>
@endsection
