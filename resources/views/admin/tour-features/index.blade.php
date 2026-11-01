@extends('admin.layouts.app')
@section('title', 'Tour Features')
@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')
    <main class="wmt-admin-main wmt-admin-manager-main">
        <header class="wmt-admin-topbar"><div><p>TOURS MANAGEMENT</p><h1>Tour Features</h1></div></header>
        @if(session('success'))<div class="wmt-admin-flash">✓ {{ session('success') }}</div>@endif
        @if(session('error'))<div class="wmt-admin-error">{{ session('error') }}</div>@endif
        <section class="wmt-admin-panel">
            <div class="wmt-feature-help"><span>✦</span><p>Add an icon and set a feature active to make it available in the tour editor and visible on public tour pages.</p></div>
            <form method="POST" action="{{ route('admin.tour-features.store') }}" class="wmt-tour-feature-create">
                @csrf
                <input name="name" required placeholder="Feature name e.g. Camel Ride">
                <label class="wmt-icon-input"><span class="wmt-feature-icon-preview"><x-tour-feature-icon name="stars" /></span><input name="icon" list="tour-feature-icons" placeholder="Choose icon e.g. camel" data-icon-input></label>
                <label><input type="checkbox" name="is_active" value="1" checked> Active</label>
                <button class="wmt-admin-primary-action">Add Feature</button>
            </form>
            <datalist id="tour-feature-icons"><option value="transfer"><option value="dune"><option value="tent"><option value="sun"><option value="falcon"><option value="wildlife"><option value="camel"><option value="sandboard"><option value="walk"><option value="stars"><option value="bbq"><option value="drinks"></datalist>
            <div class="wmt-manager-table-wrap"><table class="wmt-manager-table wmt-feature-manager-table"><thead><tr><th>Feature</th><th>Icon</th><th>Used by</th><th>Status</th><th>Actions</th></tr></thead><tbody>@foreach($features as $feature)@php($formId = 'feature-'.$feature->id)<tr><td><input form="{{ $formId }}" name="name" value="{{ $feature->name }}"></td><td><label class="wmt-icon-input"><span class="wmt-feature-icon-preview"><x-tour-feature-icon :name="$feature->icon" /></span><input form="{{ $formId }}" name="icon" value="{{ $feature->icon }}" list="tour-feature-icons" placeholder="Icon" data-icon-input></label></td><td>{{ $feature->tours_count }} tours</td><td><label class="wmt-feature-active"><input form="{{ $formId }}" type="checkbox" name="is_active" value="1" @checked($feature->is_active)> <span>{{ $feature->is_active ? 'Active' : 'Inactive' }}</span></label></td><td class="wmt-manager-actions"><form id="{{ $formId }}" method="POST" action="{{ route('admin.tour-features.update',$feature) }}">@csrf @method('PUT')</form><button form="{{ $formId }}" type="submit">Save</button><form method="POST" action="{{ route('admin.tour-features.destroy',$feature) }}" onsubmit="return confirm('Delete this unused feature?')">@csrf @method('DELETE')<button>Delete</button></form></td></tr>@endforeach</tbody></table></div>
            {{ $features->links() }}
        </section>
    </main>
</div>
<script>
document.querySelectorAll('[data-icon-input]').forEach((input) => {
    input.addEventListener('input', () => input.closest('.wmt-icon-input').classList.add('is-edited'));
});
</script>
@endsection
