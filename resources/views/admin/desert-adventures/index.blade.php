@extends('admin.layouts.app')

@section('title', 'Desert Adventures')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')

        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar">
                <div><p>CATEGORY MANAGEMENT</p><h1>Desert Adventures</h1></div>
                <div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('desert-adventures') }}">View public page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.desert-adventures.create') }}">Add adventure <span>＋</span></a></div>
            </header>

            @if (session('success'))
                <div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div>
            @endif

            <section class="wmt-admin-panel wmt-manager-intro">
                <div><span>DESERT ADVENTURES</span><h2>Manage your live experiences.</h2><p>Create, edit, feature or temporarily hide desert tours. Active adventures appear on the public Desert Adventures page automatically.</p></div>
                <div class="wmt-manager-total"><strong>{{ $adventures->total() }}</strong><span>saved adventures</span></div>
            </section>

            <section class="wmt-admin-panel wmt-manager-table-panel">
                <div class="wmt-admin-panel-heading"><div><span>YOUR CATALOGUE</span><h2>All desert adventures</h2></div><a href="{{ route('admin.desert-adventures.create') }}">Create new →</a></div>
                @if ($adventures->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your catalogue is ready.</h3><p>Create your first desert adventure and it will be saved to the database.</p><a class="wmt-admin-primary-action" href="{{ route('admin.desert-adventures.create') }}">Create adventure</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Experience</th><th>Category</th><th>Price</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>
                        @foreach ($adventures as $adventure)
                            <tr>
                                <td class="wmt-manager-name">
                                    <img src="{{ $adventure->imageUrl() }}" alt="" onerror="this.src='{{ asset('images/desert-safari.png') }}'">
                                    <span><strong>{{ $adventure->title }}</strong><small>{{ $adventure->location }}@if ($adventure->duration) · {{ $adventure->duration }}@endif</small></span>
                                </td>
                                <td><span class="wmt-category-tag">{{ $adventure->category }}</span></td>
                                <td><strong>AED {{ number_format((float) $adventure->price, 0) }}</strong></td>
                                <td><span class="wmt-admin-status {{ $adventure->is_active ? 'confirmed' : 'pending' }}">{{ $adventure->is_active ? 'Live' : 'Hidden' }}</span>@if ($adventure->is_featured)<small class="wmt-featured-note">Featured</small>@endif</td>
                                <td><small>{{ $adventure->updated_at->diffForHumans() }}</small></td>
                                <td class="wmt-manager-actions"><a href="{{ route('admin.desert-adventures.edit', $adventure) }}">Edit</a><form action="{{ route('admin.desert-adventures.destroy', $adventure) }}" method="POST" onsubmit="return confirm('Remove this desert adventure?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td>
                            </tr>
                        @endforeach
                    </tbody></table></div>
                    @if ($adventures->hasPages())
                        <nav class="wmt-admin-pagination" aria-label="Desert adventure pages">
                            @if ($adventures->onFirstPage())
                                <span class="is-disabled">← Previous</span>
                            @else
                                <a href="{{ $adventures->previousPageUrl() }}">← Previous</a>
                            @endif

                            <span class="wmt-page-numbers">
                                @foreach ($adventures->getUrlRange(1, $adventures->lastPage()) as $page => $url)
                                    @if ($page === $adventures->currentPage())
                                        <span class="is-current" aria-current="page">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </span>

                            @if ($adventures->hasMorePages())
                                <a href="{{ $adventures->nextPageUrl() }}">Next →</a>
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
