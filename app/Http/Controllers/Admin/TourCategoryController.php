<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TourCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $categories = TourCategory::query()
            ->withCount(['tours', 'subcategories'])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $searchQuery) use ($search): void {
                    $searchQuery
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('slug', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('display_order')
            ->paginate(15)
            ->withQueryString();

        return view('admin.tour-categories.index', compact('categories', 'search'));
    }

    public function create(): View
    {
        return view('admin.tour-categories.form', ['category' => new TourCategory]);
    }

    public function store(Request $request): RedirectResponse
    {
        $category = new TourCategory;
        $this->persist($request, $category);

        return redirect()->route('admin.tour-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(TourCategory $tourCategory): View
    {
        return view('admin.tour-categories.form', ['category' => $tourCategory]);
    }

    public function update(Request $request, TourCategory $tourCategory): RedirectResponse
    {
        $this->persist($request, $tourCategory);

        return redirect()->route('admin.tour-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(TourCategory $tourCategory): RedirectResponse
    {
        if ($tourCategory->tours()->exists() || $tourCategory->subcategories()->exists()) {
            return back()->with('error', 'This category has tours or subcategories. Set it inactive instead of deleting it.');
        }
        if (is_string($tourCategory->image) && $tourCategory->image !== '') {
            Storage::disk('public')->delete($tourCategory->image);
        }
        $tourCategory->delete();

        return redirect()->route('admin.tour-categories.index')->with('success', 'Category deleted successfully.');
    }

    private function persist(Request $request, TourCategory $category): void
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'slug' => ['nullable', 'string', 'max:140', Rule::unique('tour_categories', 'slug')->ignore($category)], 'description' => ['nullable', 'string'], 'image' => ['nullable', 'image', 'max:4096'], 'display_order' => ['nullable', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean'], 'meta_title' => ['nullable', 'string', 'max:255'], 'meta_description' => ['nullable', 'string', 'max:500']]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if (is_string($category->image) && $category->image !== '') {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')->store('tour-categories', 'public');
        }
        $category->fill($data)->save();
    }
}
