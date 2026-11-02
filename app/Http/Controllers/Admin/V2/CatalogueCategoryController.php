<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Models\CatalogueCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CatalogueCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $level = $request->integer('level');

        $categories = CatalogueCategory::query()
            ->with('parent')
            ->withCount('children')
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $searchQuery) use ($search): void {
                    $searchQuery
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('slug', 'like', '%'.$search.'%');
                });
            })
            ->when(in_array($level, [1, 2, 3], true), function (Builder $query) use ($level): void {
                $query->where('level', $level);
            })
            ->orderBy('level')
            ->orderBy('parent_id')
            ->orderBy('display_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.v2.categories.index', compact('categories', 'search', 'level'));
    }

    public function create(): View
    {
        return view('admin.v2.categories.form', [
            'category' => new CatalogueCategory,
            'parents' => $this->availableParents(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $category = new CatalogueCategory;
        $this->persist($request, $category);

        return redirect()->route('admin.v2.categories.index')->with('success', 'V2 category created successfully.');
    }

    public function edit(CatalogueCategory $category): View
    {
        return view('admin.v2.categories.form', [
            'category' => $category,
            'parents' => $this->availableParents($category),
        ]);
    }

    public function update(Request $request, CatalogueCategory $category): RedirectResponse
    {
        $this->persist($request, $category);

        return redirect()->route('admin.v2.categories.index')->with('success', 'V2 category updated successfully.');
    }

    public function destroy(CatalogueCategory $category): RedirectResponse
    {
        if ($category->children()->exists()) {
            return back()->with('error', 'This category has child categories. Move or delete its children first.');
        }

        if ($category->image_path !== null && str_starts_with($category->image_path, 'v2/categories/')) {
            Storage::disk('public')->delete($category->image_path);
        }

        $category->delete();

        return redirect()->route('admin.v2.categories.index')->with('success', 'V2 category deleted successfully.');
    }

    /**
     * @return Collection<int, CatalogueCategory>
     */
    private function availableParents(?CatalogueCategory $category = null): Collection
    {
        return CatalogueCategory::query()
            ->where('level', '<', 3)
            ->when($category?->exists, function (Builder $query) use ($category): void {
                $query->whereKeyNot($category->getKey());
            })
            ->orderBy('level')
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();
    }

    private function persist(Request $request, CatalogueCategory $category): void
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:180'],
            'parent_id' => ['nullable', 'integer', Rule::exists('tourism_v2.catalogue_categories', 'id')],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['draft', 'active', 'inactive'])],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $parentId = $data['parent_id'] ?? null;
        $parent = $parentId === null ? null : CatalogueCategory::query()->findOrFail($parentId);

        if ($parent !== null && $parent->level >= 3) {
            throw ValidationException::withMessages([
                'parent_id' => 'A level 3 category cannot have children. The catalogue has a maximum of three levels.',
            ]);
        }

        if ($parent !== null && $category->exists && $parent->is($category)) {
            throw ValidationException::withMessages([
                'parent_id' => 'A category cannot be its own parent.',
            ]);
        }

        if ($category->exists && $parentId !== $category->parent_id && $category->children()->exists()) {
            throw ValidationException::withMessages([
                'parent_id' => 'Move or delete child categories before changing this category parent.',
            ]);
        }

        $data['slug'] = ($data['slug'] ?? '') !== '' ? $data['slug'] : Str::slug($data['name']);
        $data['level'] = $parent === null ? 1 : $parent->level + 1;
        $data['display_order'] = $data['display_order'] ?? 0;

        $sameParentSlug = CatalogueCategory::query()
            ->where('slug', $data['slug'])
            ->when($parentId === null, function (Builder $query): void {
                $query->whereNull('parent_id');
            }, function (Builder $query) use ($parentId): void {
                $query->where('parent_id', $parentId);
            })
            ->when($category->exists, function (Builder $query) use ($category): void {
                $query->whereKeyNot($category->getKey());
            })
            ->exists();

        if ($sameParentSlug) {
            throw ValidationException::withMessages([
                'slug' => 'This slug is already used under the selected parent category.',
            ]);
        }

        unset($data['image']);

        if ($request->hasFile('image')) {
            if ($category->image_path !== null && str_starts_with($category->image_path, 'v2/categories/')) {
                Storage::disk('public')->delete($category->image_path);
            }

            $data['image_path'] = $request->file('image')->store('v2/categories', 'public');
        }

        $category->fill($data)->save();
    }
}
