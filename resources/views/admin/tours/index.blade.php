@extends('admin.layouts.app')

@section('title', 'Tours Management')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>TOURS MANAGEMENT</p><h1>All Tours</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-primary-action" href="{{ route('admin.tours.create') }}">Add New Tour <span>＋</span></a></div></header>
            @if(session('success'))<div class="wmt-admin-flash">✓ {{ session('success') }}</div>@endif
            @if(session('error'))<div class="wmt-admin-error">{{ session('error') }}</div>@endif
            <section class="wmt-admin-panel">
                <form class="wmt-tour-filters" method="GET"><input name="search" value="{{ request('search') }}" placeholder="Search tours by name"><select name="category"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((string)request('category') === (string)$category->id)>{{ $category->name }}</option>@endforeach</select><select name="status"><option value="">All statuses</option>@foreach(['active'=>'Active','inactive'=>'Inactive','draft'=>'Draft'] as $value=>$label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select><button type="submit">Filter</button><a href="{{ route('admin.tours.index') }}">Reset</a></form>
                <div class="wmt-admin-panel-heading"><div><span>DATABASE CATALOGUE</span><h2>{{ $tours->total() }} managed tours</h2></div></div>
                @if($tours->isEmpty())<div class="wmt-admin-empty"><b>✦</b><h3>No tours found.</h3><p>Create a tour once and it will power its card, details, packages and availability.</p><a class="wmt-admin-primary-action" href="{{ route('admin.tours.create') }}">Create tour</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>ID</th><th>Tour</th><th>Category</th><th>Starting price</th><th>Badges</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead><tbody>@foreach($tours as $tour)<tr><td>#{{ $tour->id }}</td><td class="wmt-manager-name"><img src="{{ $tour->imageUrl() }}" alt=""><span><strong>{{ $tour->name }}</strong><small>{{ $tour->subcategory?->name ?? 'No subcategory' }}</small></span></td><td>{{ $tour->category?->name }}</td><td><strong>{{ $tour->currency }} {{ number_format((float)$tour->starting_price, 0) }}</strong></td><td>@if($tour->is_featured)<small class="wmt-featured-note">Featured</small>@endif @if($tour->is_bestseller)<small class="wmt-featured-note">Bestseller</small>@endif</td><td><span class="wmt-admin-status {{ $tour->status === 'active' ? 'confirmed' : 'pending' }}">{{ ucfirst($tour->status) }}</span></td><td><small>{{ $tour->created_at->format('d M Y') }}</small></td><td class="wmt-manager-actions"><a href="{{ route('admin.tours.show', $tour) }}">View</a><a href="{{ route('admin.tours.edit', $tour) }}">Edit</a><form method="POST" action="{{ route('admin.tours.destroy', $tour) }}" onsubmit="return confirm('Delete this tour and its gallery, packages and itinerary?')">@csrf @method('DELETE')<button>Delete</button></form></td></tr>@endforeach</tbody></table></div>
                    @if($tours->hasPages())<nav class="wmt-admin-pagination">@if($tours->onFirstPage())<span class="is-disabled">← Previous</span>@else<a href="{{ $tours->previousPageUrl() }}">← Previous</a>@endif <span class="wmt-page-numbers">@foreach($tours->getUrlRange(1,$tours->lastPage()) as $page=>$url)@if($page===$tours->currentPage())<span class="is-current">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif @endforeach</span> @if($tours->hasMorePages())<a href="{{ $tours->nextPageUrl() }}">Next →</a>@else<span class="is-disabled">Next →</span>@endif</nav>@endif
                @endif
            </section>
        </main>
    </div>
@endsection
