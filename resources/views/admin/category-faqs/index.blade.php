@extends('admin.layouts.app')

@section('title', 'Category FAQs')

@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')
    <main class="wmt-admin-main wmt-admin-manager-main">
        <header class="wmt-admin-topbar"><div><p>TOURS MANAGEMENT</p><h1>Category FAQs</h1></div><a class="wmt-admin-primary-action" href="{{ route('admin.category-faqs.create') }}">Add FAQ</a></header>
        @if(session('success'))<div class="wmt-admin-success">{{ session('success') }}</div>@endif
        <section class="wmt-admin-panel"><div class="wmt-admin-table-wrap"><table class="wmt-admin-table"><thead><tr><th>Category</th><th>Question</th><th>Order</th><th>Status</th><th></th></tr></thead><tbody>@forelse($faqs as $faq)<tr><td>{{ $faq->category?->name }}</td><td>{{ $faq->question }}</td><td>{{ $faq->display_order }}</td><td>{{ $faq->is_active ? 'Active' : 'Hidden' }}</td><td><a href="{{ route('admin.category-faqs.edit', $faq) }}">Edit</a><form method="POST" action="{{ route('admin.category-faqs.destroy', $faq) }}" class="wmt-inline-form">@csrf @method('DELETE')<button type="submit">Delete</button></form></td></tr>@empty<tr><td colspan="5">No category FAQs yet.</td></tr>@endforelse</tbody></table></div>{{ $faqs->links() }}</section>
    </main>
</div>
@endsection
