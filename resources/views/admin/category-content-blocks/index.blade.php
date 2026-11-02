@extends('admin.layouts.app')

@section('title', 'Category Story Blocks')

@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')
    <main class="wmt-admin-main wmt-admin-manager-main">
        <header class="wmt-admin-topbar"><div><p>TOURS MANAGEMENT</p><h1>Category Story Blocks</h1></div><a class="wmt-admin-primary-action" href="{{ route('admin.category-content-blocks.create') }}">Add story block</a></header>
        @if(session('success'))<div class="wmt-admin-success">{{ session('success') }}</div>@endif
        <section class="wmt-admin-panel"><div class="wmt-admin-table-wrap"><table class="wmt-admin-table"><thead><tr><th>Category</th><th>Heading</th><th>Layout</th><th>Order</th><th>Status</th><th></th></tr></thead><tbody>@forelse($blocks as $block)<tr><td>{{ $block->category?->name }}</td><td>{{ $block->heading }}</td><td>{{ $block->layout === 'image_right' ? 'Image right' : 'Image left' }}</td><td>{{ $block->display_order }}</td><td>{{ $block->is_active ? 'Active' : 'Hidden' }}</td><td><a href="{{ route('admin.category-content-blocks.edit', $block) }}">Edit</a><form method="POST" action="{{ route('admin.category-content-blocks.destroy', $block) }}" class="wmt-inline-form">@csrf @method('DELETE')<button type="submit">Delete</button></form></td></tr>@empty<tr><td colspan="6">No category story blocks yet.</td></tr>@endforelse</tbody></table></div>{{ $blocks->links() }}</section>
    </main>
</div>
@endsection
