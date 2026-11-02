@extends('admin.layouts.app')

@section('title', $faq->exists ? 'Edit Category FAQ' : 'Add Category FAQ')

@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')
    <main class="wmt-admin-main wmt-admin-manager-main">
        <header class="wmt-admin-topbar"><div><p>TOURS MANAGEMENT</p><h1>{{ $faq->exists ? 'Edit Category FAQ' : 'Add Category FAQ' }}</h1></div></header>
        @if($errors->any())<div class="wmt-admin-error">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
        <form method="POST" class="wmt-admin-form" action="{{ $faq->exists ? route('admin.category-faqs.update', $faq) : route('admin.category-faqs.store') }}">@csrf @if($faq->exists)@method('PUT')@endif
            <section class="wmt-admin-panel"><div class="wmt-form-grid"><label>Category *<select name="tour_category_id" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((int) old('tour_category_id', $faq->tour_category_id) === $category->id)>{{ $category->name }}</option>@endforeach</select></label><label>Display order *<input required type="number" min="0" name="display_order" value="{{ old('display_order', $faq->display_order ?? 0) }}"></label><label class="wmt-form-wide">Question *<input required name="question" maxlength="255" value="{{ old('question', $faq->question) }}"></label><label class="wmt-form-wide">Answer *<textarea required name="answer">{{ old('answer', $faq->answer) }}</textarea></label></div><div class="wmt-form-options"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $faq->exists ? $faq->is_active : true))><span><strong>Active</strong><small>Show this answer on the public category page.</small></span></label></div></section>
            <div class="wmt-form-actions"><a href="{{ route('admin.category-faqs.index') }}">Cancel</a><button class="wmt-admin-primary-action">Save FAQ</button></div>
        </form>
    </main>
</div>
@endsection
