@extends('admin.layouts.app')

@section('title', $category->exists ? 'Edit V2 Category' : 'Add V2 Category')

@section('content')
<div class="wmt-admin-shell">
    @include('admin.partials.sidebar')

    <main class="wmt-admin-main wmt-admin-manager-main">
        <header class="wmt-admin-topbar">
            <div>
                <p>NEW CATALOGUE · ISOLATED DATABASE</p>
                <h1>{{ $category->exists ? 'Edit Category' : 'Add Category' }}</h1>
            </div>
        </header>

        @if ($errors->any())
            <div class="wmt-admin-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data" class="wmt-admin-form" action="{{ $category->exists ? route('admin.v2.categories.update', $category) : route('admin.v2.categories.store') }}">
            @csrf
            @if ($category->exists)
                @method('PUT')
            @endif

            <section class="wmt-admin-panel">
                <p>Choose no parent for a main category. Selecting a main category creates a subcategory; selecting a subcategory creates a child subcategory. Level 3 categories cannot have children.</p>

                <div class="wmt-form-grid">
                    <label>
                        Parent category
                        <select name="parent_id">
                            <option value="">No parent — Main category (Level 1)</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}" @selected((int) old('parent_id', $category->parent_id) === $parent->id)>
                                    {{ str_repeat('— ', $parent->level - 1) }}{{ $parent->name }} (Level {{ $parent->level }})
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        Display order
                        <input type="number" min="0" name="display_order" value="{{ old('display_order', $category->display_order ?? 0) }}">
                    </label>

                    <label>
                        Category name *
                        <input required maxlength="150" name="name" value="{{ old('name', $category->name) }}">
                    </label>

                    <label>
                        Slug
                        <input maxlength="180" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="Generated from the name when empty">
                    </label>

                    <label>
                        Status *
                        <select required name="status">
                            @foreach (['draft' => 'Draft', 'active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $category->status ?? 'draft') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        Image
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
                    </label>

                    <label class="wmt-form-wide">
                        Description
                        <textarea name="description">{{ old('description', $category->description) }}</textarea>
                    </label>

                    <label>
                        SEO title
                        <input maxlength="255" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}">
                    </label>

                    <label>
                        SEO description
                        <textarea maxlength="500" name="meta_description">{{ old('meta_description', $category->meta_description) }}</textarea>
                    </label>
                </div>

                @if ($category->image_path)
                    <p>Current image: <a href="{{ asset('storage/'.$category->image_path) }}" target="_blank" rel="noopener">View image</a></p>
                @endif
            </section>

            <div class="wmt-form-actions">
                <a href="{{ route('admin.v2.categories.index') }}">Cancel</a>
                <button class="wmt-admin-primary-action">Save category</button>
            </div>
        </form>
    </main>
</div>
@endsection
