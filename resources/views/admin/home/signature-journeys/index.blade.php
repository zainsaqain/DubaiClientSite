@extends('admin.layouts.app')

@section('title', 'Home Signature Journey')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>HOME PAGE</p><h1>Signature Journey</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('home') }}">View home page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.home.signature-journeys.create') }}">Create section <span>＋</span></a></div></header>
            @if (session('success'))<div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div>@endif
            <section class="wmt-admin-panel wmt-manager-intro"><div><span>HOME SIGNATURE JOURNEY</span><h2>Manage the WMT Select story.</h2><p>Update the large image, heading, story, three highlights and call-to-action shown on the home page.</p></div><div class="wmt-manager-total"><strong>{{ $journeys->total() }}</strong><span>saved sections</span></div></section>
            <section class="wmt-admin-panel wmt-manager-table-panel"><div class="wmt-admin-panel-heading"><div><span>HOME CONTENT</span><h2>All signature journeys</h2></div><a href="{{ route('admin.home.signature-journeys.create') }}">Create new →</a></div>
                @if ($journeys->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your Signature Journey is ready.</h3><p>Create the first section and it will appear on the home page.</p><a class="wmt-admin-primary-action" href="{{ route('admin.home.signature-journeys.create') }}">Create section</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Section</th><th>Order</th><th>Button</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>@foreach ($journeys as $journey)<tr><td class="wmt-manager-name"><img src="{{ $journey->imageUrl() }}" alt=""><span><strong>{{ $journey->title }}</strong><small>{{ $journey->eyebrow }}</small></span></td><td><strong>#{{ $journey->display_order }}</strong></td><td><span class="wmt-category-tag">{{ $journey->button_label }}</span></td><td><span class="wmt-admin-status {{ $journey->is_active ? 'confirmed' : 'pending' }}">{{ $journey->is_active ? 'Live' : 'Hidden' }}</span></td><td><small>{{ $journey->updated_at->diffForHumans() }}</small></td><td class="wmt-manager-actions"><a href="{{ route('admin.home.signature-journeys.edit', $journey) }}">Edit</a><form action="{{ route('admin.home.signature-journeys.destroy', $journey) }}" method="POST" onsubmit="return confirm('Remove this section?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td></tr>@endforeach</tbody></table></div>
                @endif
            </section>
        </main>
    </div>
@endsection
