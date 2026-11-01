@extends('admin.layouts.app')

@section('title', 'Home Promo Cards')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>HOME PAGE</p><h1>Promo Cards</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('home') }}">View home page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.home.promo-cards.create') }}">Create card <span>＋</span></a></div></header>
            @if (session('success'))<div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div>@endif
            <section class="wmt-admin-panel wmt-manager-intro"><div><span>HOME PROMOTIONS</span><h2>Manage your featured home cards.</h2><p>Update the image, text, button, link, display order and visibility of the two visual cards below the home hero.</p></div><div class="wmt-manager-total"><strong>{{ $cards->total() }}</strong><span>saved cards</span></div></section>
            <section class="wmt-admin-panel wmt-manager-table-panel"><div class="wmt-admin-panel-heading"><div><span>HOME CONTENT</span><h2>All promo cards</h2></div><a href="{{ route('admin.home.promo-cards.create') }}">Create new →</a></div>
                @if ($cards->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your promo cards are ready.</h3><p>Create your first home promotion and it will appear on the home page.</p><a class="wmt-admin-primary-action" href="{{ route('admin.home.promo-cards.create') }}">Create card</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Promo card</th><th>Order</th><th>Button</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>@foreach ($cards as $card)<tr><td class="wmt-manager-name"><img src="{{ $card->imageUrl() }}" alt=""><span><strong>{{ $card->title }}</strong><small>{{ $card->eyebrow }}</small></span></td><td><strong>#{{ $card->display_order }}</strong></td><td><span class="wmt-category-tag">{{ $card->button_label }}</span></td><td><span class="wmt-admin-status {{ $card->is_active ? 'confirmed' : 'pending' }}">{{ $card->is_active ? 'Live' : 'Hidden' }}</span></td><td><small>{{ $card->updated_at->diffForHumans() }}</small></td><td class="wmt-manager-actions"><a href="{{ route('admin.home.promo-cards.edit', $card) }}">Edit</a><form action="{{ route('admin.home.promo-cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Remove this promo card?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td></tr>@endforeach</tbody></table></div>
                @endif
            </section>
        </main>
    </div>
@endsection
