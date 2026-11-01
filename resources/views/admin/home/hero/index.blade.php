@extends('admin.layouts.app')

@section('title', 'Home Hero Slides')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>HOME PAGE</p><h1>Hero Slides</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('home') }}">View home page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.home.hero.create') }}">Create slide <span>＋</span></a></div></header>
            @if (session('success'))<div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div>@endif
            <section class="wmt-admin-panel wmt-manager-intro"><div><span>HOME PAGE HERO</span><h2>Manage your first impression.</h2><p>Control the rotating home page slides, headings, images, buttons, highlight text and display order.</p></div><div class="wmt-manager-total"><strong>{{ $slides->total() }}</strong><span>saved slides</span></div></section>
            <section class="wmt-admin-panel wmt-manager-table-panel"><div class="wmt-admin-panel-heading"><div><span>HOME CONTENT</span><h2>All hero slides</h2></div><a href="{{ route('admin.home.hero.create') }}">Create new →</a></div>
                @if ($slides->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your home hero is ready.</h3><p>Create your first slide and it will appear on the home page.</p><a class="wmt-admin-primary-action" href="{{ route('admin.home.hero.create') }}">Create slide</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Hero slide</th><th>Order</th><th>Primary action</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>@foreach ($slides as $slide)<tr><td class="wmt-manager-name"><img src="{{ $slide->imageUrl() }}" alt=""><span><strong>{{ $slide->heading }}</strong><small>{{ $slide->badge }}</small></span></td><td><strong>#{{ $slide->display_order }}</strong></td><td><span class="wmt-category-tag">{{ $slide->primary_label }}</span></td><td><span class="wmt-admin-status {{ $slide->is_active ? 'confirmed' : 'pending' }}">{{ $slide->is_active ? 'Live' : 'Hidden' }}</span></td><td><small>{{ $slide->updated_at->diffForHumans() }}</small></td><td class="wmt-manager-actions"><a href="{{ route('admin.home.hero.edit', $slide) }}">Edit</a><form action="{{ route('admin.home.hero.destroy', $slide) }}" method="POST" onsubmit="return confirm('Remove this hero slide?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td></tr>@endforeach</tbody></table></div>
                @endif
            </section>
        </main>
    </div>
@endsection
