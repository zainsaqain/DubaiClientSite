@extends('admin.layouts.app')

@section('title', 'Why Us Sections')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>PAGE MANAGEMENT</p><h1>Why Us Sections</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('why-us') }}">View public page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.why-us.create') }}">Add section <span>＋</span></a></div></header>
            @if (session('success'))<div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div>@endif
            <section class="wmt-admin-panel wmt-manager-intro"><div><span>WHY WAHEED MURAD TOURISM</span><h2>Manage the stories behind your service.</h2><p>Create, edit, reorder, hide or delete the feature sections that appear on the public Why Us page.</p></div><div class="wmt-manager-total"><strong>{{ $features->total() }}</strong><span>saved sections</span></div></section>
            <section class="wmt-admin-panel wmt-manager-table-panel">
                <div class="wmt-admin-panel-heading"><div><span>YOUR PAGE CONTENT</span><h2>All Why Us sections</h2></div><a href="{{ route('admin.why-us.create') }}">Create new →</a></div>
                @if ($features->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your Why Us page is ready.</h3><p>Create your first feature section and it will be saved to the database.</p><a class="wmt-admin-primary-action" href="{{ route('admin.why-us.create') }}">Create section</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Section</th><th>Order</th><th>Layout</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>
                        @foreach ($features as $feature)
                            <tr><td class="wmt-manager-name"><img src="{{ $feature->imageUrl() }}" alt=""><span><strong>{{ $feature->title }}</strong><small>{{ $feature->eyebrow }}</small></span></td><td><strong>#{{ $feature->display_order }}</strong></td><td><span class="wmt-category-tag">{{ $feature->is_reversed ? 'Image right' : 'Image left' }}</span></td><td><span class="wmt-admin-status {{ $feature->is_active ? 'confirmed' : 'pending' }}">{{ $feature->is_active ? 'Live' : 'Hidden' }}</span></td><td><small>{{ $feature->updated_at->diffForHumans() }}</small></td><td class="wmt-manager-actions"><a href="{{ route('admin.why-us.edit', $feature) }}">Edit</a><form action="{{ route('admin.why-us.destroy', $feature) }}" method="POST" onsubmit="return confirm('Remove this Why Us section?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td></tr>
                        @endforeach
                    </tbody></table></div>
                    @if ($features->hasPages())
                        <nav class="wmt-admin-pagination" aria-label="Why Us section pages">
                            @if ($features->onFirstPage())<span class="is-disabled">← Previous</span>@else<a href="{{ $features->previousPageUrl() }}">← Previous</a>@endif
                            <span class="wmt-page-numbers">@foreach ($features->getUrlRange(1, $features->lastPage()) as $page => $url)@if ($page === $features->currentPage())<span class="is-current" aria-current="page">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif @endforeach</span>
                            @if ($features->hasMorePages())<a href="{{ $features->nextPageUrl() }}">Next →</a>@else<span class="is-disabled">Next →</span>@endif
                        </nav>
                    @endif
                @endif
            </section>
        </main>
    </div>
@endsection
