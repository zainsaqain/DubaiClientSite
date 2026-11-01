@extends('admin.layouts.app')

@section('title', 'Transfers')

@section('content')
    <div class="wmt-admin-shell">
        @include('admin.partials.sidebar')
        <main class="wmt-admin-main wmt-admin-manager-main">
            <header class="wmt-admin-topbar"><div><p>CATEGORY MANAGEMENT</p><h1>Transfers</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-site-link" href="{{ route('transfers') }}">View public page <span>↗</span></a><a class="wmt-admin-primary-action" href="{{ route('admin.transfers.create') }}">Add transfer <span>＋</span></a></div></header>
            @if (session('success'))<div class="wmt-admin-flash" role="status">✓ {{ session('success') }}</div>@endif
            <section class="wmt-admin-panel wmt-manager-intro"><div><span>TRANSFERS</span><h2>Manage every journey.</h2><p>Create, edit, feature, hide or delete your airport and private transfer services. Live records appear on the public Transfers page automatically.</p></div><div class="wmt-manager-total"><strong>{{ $transfers->total() }}</strong><span>saved transfers</span></div></section>
            <section class="wmt-admin-panel wmt-manager-table-panel">
                <div class="wmt-admin-panel-heading"><div><span>YOUR CATALOGUE</span><h2>All transfers</h2></div><a href="{{ route('admin.transfers.create') }}">Create new →</a></div>
                @if ($transfers->isEmpty())
                    <div class="wmt-admin-empty"><b>✦</b><h3>Your transfer catalogue is ready.</h3><p>Create your first transfer service and it will be saved to the database.</p><a class="wmt-admin-primary-action" href="{{ route('admin.transfers.create') }}">Create transfer</a></div>
                @else
                    <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Transfer</th><th>Type</th><th>Price</th><th>Visibility</th><th>Updated</th><th><span class="sr-only">Actions</span></th></tr></thead><tbody>
                        @foreach ($transfers as $transfer)
                            <tr><td class="wmt-manager-name"><img src="{{ $transfer->imageUrl() }}" alt="" onerror="this.src='{{ asset('images/airport-transfer.png') }}'"><span><strong>{{ $transfer->title }}</strong><small>{{ $transfer->location }}</small></span></td><td><span class="wmt-category-tag">{{ $transfer->transfer_type }}</span></td><td><strong>PKR {{ number_format((float) $transfer->price, 0) }}</strong></td><td><span class="wmt-admin-status {{ $transfer->is_active ? 'confirmed' : 'pending' }}">{{ $transfer->is_active ? 'Live' : 'Hidden' }}</span>@if ($transfer->is_featured)<small class="wmt-featured-note">Featured</small>@endif</td><td><small>{{ $transfer->updated_at->diffForHumans() }}</small></td><td class="wmt-manager-actions"><a href="{{ route('admin.transfers.edit', $transfer) }}">Edit</a><form action="{{ route('admin.transfers.destroy', $transfer) }}" method="POST" onsubmit="return confirm('Remove this transfer?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td></tr>
                        @endforeach
                    </tbody></table></div>
                    @if ($transfers->hasPages())
                        <nav class="wmt-admin-pagination" aria-label="Transfer pages">
                            @if ($transfers->onFirstPage())
                                <span class="is-disabled">← Previous</span>
                            @else
                                <a href="{{ $transfers->previousPageUrl() }}">← Previous</a>
                            @endif
                            <span class="wmt-page-numbers">
                                @foreach ($transfers->getUrlRange(1, $transfers->lastPage()) as $page => $url)
                                    @if ($page === $transfers->currentPage())
                                        <span class="is-current" aria-current="page">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </span>
                            @if ($transfers->hasMorePages())
                                <a href="{{ $transfers->nextPageUrl() }}">Next →</a>
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
