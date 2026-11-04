@extends('admin.layouts.app')

@section('title', 'Bank Transfer Payments')

@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')
    <main class="wmt-admin-main wmt-admin-manager-main"><header class="wmt-admin-topbar"><div><p>PAYMENTS</p><h1>Bank Transfer Payments</h1></div><div class="wmt-admin-actions"><a class="wmt-admin-primary-action" href="{{ route('admin.bank-transfer-settings.edit') }}">Bank settings</a></div></header>
        <section class="wmt-admin-panel"><form class="wmt-tour-filters" method="GET"><select name="status"><option value="">All statuses</option>@foreach(['pending_payment','pending_verification','paid','rejected'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucwords(str_replace('_', ' ', $status)) }}</option>@endforeach</select><button type="submit">Filter</button><a href="{{ route('admin.bank-transfer-payments.index') }}">Reset</a></form>
            @if($payments->isEmpty())<div class="wmt-admin-empty"><h3>No bank transfer payments found.</h3></div>@else
            <div class="wmt-manager-table-wrap"><table class="wmt-manager-table"><thead><tr><th>Order</th><th>Customer</th><th>Amount</th><th>Reference</th><th>Status</th><th>Submitted</th><th></th></tr></thead><tbody>@foreach($payments as $payment)<tr><td><strong>{{ $payment->booking->order_number }}</strong><small>{{ $payment->booking->tour->name }}</small></td><td>{{ $payment->booking->user->name }}<small>{{ $payment->booking->user->email }}</small></td><td>{{ $payment->booking->currency }} {{ number_format((float)$payment->booking->amount, 2) }}</td><td>{{ $payment->transaction_reference ?: '—' }}</td><td><span class="wmt-admin-status {{ $payment->status === 'paid' ? 'confirmed' : 'pending' }}">{{ ucwords(str_replace('_', ' ', $payment->status)) }}</span></td><td>{{ $payment->submitted_at?->format('d M Y H:i') ?: '—' }}</td><td><a href="{{ route('admin.bank-transfer-payments.show', $payment) }}">View</a></td></tr>@endforeach</tbody></table></div>{{ $payments->links() }}@endif
        </section>
    </main>
</div>
@endsection
