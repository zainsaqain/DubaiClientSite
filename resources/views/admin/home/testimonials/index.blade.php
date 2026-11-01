@extends('admin.layouts.app')

@section('title', 'Home Testimonials')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>HOME PAGE</p><h1>Testimonials</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('home') }}">View home page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.home.testimonials.create') }}">Create testimonial <span>＋</span></a></div></header>
            @if (session('success'))<div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div>@endif
            <section class="wmt-admin-panel wmt-manager-intro"><div><span>GUEST EXPERIENCES</span><h2>Manage traveller stories.</h2><p>Add, edit, feature, hide or remove guest reviews shown in the premium home testimonial section.</p></div><div class="wmt-manager-total"><strong>{{ $testimonials->total() }}</strong><span>saved reviews</span></div></section>
            <section class="wmt-admin-panel wmt-manager-table-panel"><div class="wmt-admin-panel-heading"><div><span>HOME CONTENT</span><h2>All testimonials</h2></div><a href="{{ route('admin.home.testimonials.create') }}">Create new →</a></div>
                @if ($testimonials->isEmpty())<div class="wmt-admin-empty"><b>✦</b><h3>Your testimonial section is ready.</h3><p>Create your first guest review to display on the home page.</p><a class="wmt-admin-primary-action" href="{{ route('admin.home.testimonials.create') }}">Create testimonial</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Guest</th><th>Rating</th><th>Order</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>@foreach ($testimonials as $testimonial)<tr><td class="wmt-manager-name"><img src="{{ $testimonial->avatarUrl() }}" alt=""><span><strong>{{ $testimonial->name }}</strong><small>{{ $testimonial->country }}</small></span></td><td><strong>{{ str_repeat('★', $testimonial->rating) }}</strong></td><td><strong>#{{ $testimonial->display_order }}</strong></td><td><span class="wmt-admin-status {{ $testimonial->is_active ? 'confirmed' : 'pending' }}">{{ $testimonial->is_active ? 'Live' : 'Hidden' }}</span>@if ($testimonial->is_featured)<small class="wmt-featured-note">Featured</small>@endif</td><td><small>{{ $testimonial->updated_at->diffForHumans() }}</small></td><td class="wmt-manager-actions"><a href="{{ route('admin.home.testimonials.edit', $testimonial) }}">Edit</a><form action="{{ route('admin.home.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Remove this testimonial?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td></tr>@endforeach</tbody></table></div>
                @endif
            </section>
        </main>
    </div>
@endsection
