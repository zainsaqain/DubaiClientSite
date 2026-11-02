@extends('admin.layouts.app')

@section('title', $block->exists ? 'Edit Category Story Block' : 'Add Category Story Block')

@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')
    <main class="wmt-admin-main wmt-admin-manager-main">
        <header class="wmt-admin-topbar"><div><p>TOURS MANAGEMENT</p><h1>{{ $block->exists ? 'Edit Category Story Block' : 'Add Category Story Block' }}</h1></div></header>
        @if($errors->any())<div class="wmt-admin-error">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
        <form method="POST" enctype="multipart/form-data" class="wmt-admin-form" action="{{ $block->exists ? route('admin.category-content-blocks.update', $block) : route('admin.category-content-blocks.store') }}">@csrf @if($block->exists)@method('PUT')@endif
            <section class="wmt-admin-panel"><div class="wmt-form-grid"><label>Category *<select name="tour_category_id" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((int) old('tour_category_id', $block->tour_category_id) === $category->id)>{{ $category->name }}</option>@endforeach</select></label><label>Display order *<input required type="number" min="0" name="display_order" value="{{ old('display_order', $block->display_order ?? 0) }}"></label><label class="wmt-form-wide">Heading *<input required name="heading" maxlength="180" value="{{ old('heading', $block->heading) }}"></label><label class="wmt-form-wide">Story text *<textarea required name="body">{{ old('body', $block->body) }}</textarea></label><label>Image<input type="file" name="image" accept="image/*"></label><label>Image alt text<input name="image_alt" value="{{ old('image_alt', $block->image_alt) }}"></label><label>Layout *<select name="layout"><option value="image_left" @selected(old('layout', $block->layout) === 'image_left')>Image left</option><option value="image_right" @selected(old('layout', $block->layout) === 'image_right')>Image right</option></select></label></div><div class="wmt-form-options"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $block->exists ? $block->is_active : true))><span><strong>Active</strong><small>Show this story on the public category page.</small></span></label></div></section>
            <div class="wmt-form-actions"><a href="{{ route('admin.category-content-blocks.index') }}">Cancel</a><button class="wmt-admin-primary-action">Save story block</button></div>
        </form>
    </main>
</div>
@endsection
