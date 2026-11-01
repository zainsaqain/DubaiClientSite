@extends('admin.layouts.app')

@section('title', 'Attractions')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>CATEGORY MANAGEMENT</p><h1>Attractions</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('attractions') }}">View public page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.attractions.create') }}">Add attraction <span>＋</span></a></div></header>
            @if (session('success')) <div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div> @endif
            <section class="wmt-admin-panel wmt-manager-intro"><div><span>ATTRACTIONS</span><h2>Manage your live attractions.</h2><p>Create, edit, feature, hide or delete attractions. Live records appear on the public Attractions page automatically.</p></div><div class="wmt-manager-total"><strong>{{ $attractions->total() }}</strong><span>saved attractions</span></div></section>
            <section class="wmt-admin-panel wmt-manager-table-panel">
                <div class="wmt-admin-panel-heading"><div><span>YOUR CATALOGUE</span><h2>All attractions</h2></div><a href="{{ route('admin.attractions.create') }}">Create new →</a></div>
                @if ($attractions->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your attraction catalogue is ready.</h3><p>Create your first attraction and it will be saved to the database.</p><a class="wmt-admin-primary-action" href="{{ route('admin.attractions.create') }}">Create attraction</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Attraction</th><th>Type</th><th>Price</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>@foreach ($attractions as $attraction)<tr><td class="wmt-manager-name"><img src="{{ $attraction->imageUrl() }}" alt="" onerror="this.src='{{ asset('images/dubai-attractions.png') }}'"><span><strong>{{ $attraction->title }}</strong><small>{{ $attraction->location }}</small></span></td><td><span class="wmt-category-tag">{{ $attraction->attraction_type }}</span></td><td><strong>PKR {{ number_format((float) $attraction->price, 0) }}</strong></td><td><span class="wmt-admin-status {{ $attraction->is_active ? 'confirmed' : 'pending' }}">{{ $attraction->is_active ? 'Live' : 'Hidden' }}</span>@if ($attraction->is_featured)<small class="wmt-featured-note">Featured</small>@endif</td><td><small>{{ $attraction->updated_at->diffForHumans() }}</small></td><td class="wmt-manager-actions"><a href="{{ route('admin.attractions.edit', $attraction) }}">Edit</a><form action="{{ route('admin.attractions.destroy', $attraction) }}" method="POST" onsubmit="return confirm('Remove this attraction?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td></tr>@endforeach</tbody></table></div>
                    @if ($attractions->hasPages())
                        <nav class="wmt-admin-pagination" aria-label="Attraction pages">
                            @if ($attractions->onFirstPage())
                                <span class="is-disabled">← Previous</span>
                            @else
                                <a href="{{ $attractions->previousPageUrl() }}">← Previous</a>
                            @endif
                            <span class="wmt-page-numbers">
                                @foreach ($attractions->getUrlRange(1, $attractions->lastPage()) as $page => $url)
                                    @if ($page === $attractions->currentPage())
                                        <span class="is-current" aria-current="page">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </span>
                            @if ($attractions->hasMorePages())
                                <a href="{{ $attractions->nextPageUrl() }}">Next →</a>
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
