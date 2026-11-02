@extends('admin.layouts.app')

@section('title', 'V2 Catalogue Categories')

@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')

    <main class="wmt-admin-main wmt-admin-manager-main">
        <header class="wmt-admin-topbar">
            <div>
                <p>NEW CATALOGUE · ISOLATED DATABASE</p>
                <h1>Categories</h1>
            </div>
            <a class="wmt-admin-primary-action" href="{{ route('admin.v2.categories.create') }}">Add Category <span>＋</span></a>
        </header>

        @if (session('success'))
            <div class="wmt-admin-flash">✓ {{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="wmt-admin-error">{{ session('error') }}</div>
        @endif

        <form class="wmt-tour-filters" method="GET">
            <input type="search" name="search" value="{{ $search }}" placeholder="Search V2 categories" aria-label="Search V2 categories">
            <select name="level" aria-label="Filter by level">
                <option value="">All levels</option>
                @foreach ([1 => 'Main category', 2 => 'Subcategory', 3 => 'Child subcategory'] as $value => $label)
                    <option value="{{ $value }}" @selected((int) $level === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit">Search</button>
            @if ($search || $level)
                <a href="{{ route('admin.v2.categories.index') }}">Clear</a>
            @endif
        </form>

        <section class="wmt-admin-panel">
            <div class="wmt-manager-table-wrap">
                <table class="wmt-manager-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Level</th>
                            <th>Parent</th>
                            <th>Children</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="wmt-manager-name">
                                    @if ($category->image_path)
                                        <img src="{{ asset('storage/'.$category->image_path) }}" alt="">
                                    @endif
                                    <span><strong>{{ $category->name }}</strong><small>{{ $category->slug }}</small></span>
                                </td>
                                <td>{{ ['Main', 'Subcategory', 'Child subcategory'][$category->level - 1] }}</td>
                                <td>{{ $category->parent?->name ?? '—' }}</td>
                                <td>{{ $category->children_count }}</td>
                                <td>{{ $category->display_order }}</td>
                                <td><span class="wmt-admin-status {{ $category->status === 'active' ? 'confirmed' : 'pending' }}">{{ ucfirst($category->status) }}</span></td>
                                <td class="wmt-manager-actions">
                                    <a href="{{ route('admin.v2.categories.edit', $category) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.v2.categories.destroy', $category) }}" onsubmit="return confirm('Delete this V2 category? Categories with children cannot be deleted.')">
                                        @csrf
                                        @method('DELETE')
                                        <button>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7">No V2 categories yet. Add the first main category to begin the new catalogue.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $categories->links() }}
        </section>
    </main>
</div>
@endsection
