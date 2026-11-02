<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourCategory;
use App\Models\TourSubcategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TourSubcategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $subcategories = TourSubcategory::query()
            ->with('category')
            ->withCount('tours')
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $searchQuery) use ($search): void {
                    $searchQuery
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('slug', 'like', '%'.$search.'%')
                        ->orWhereHas('category', fn (Builder $categoryQuery): Builder => $categoryQuery->where('name', 'like', '%'.$search.'%'));
                });
            })
            ->orderBy('display_order')
            ->paginate(15)
            ->withQueryString();

        return view('admin.tour-subcategories.index', compact('search', 'subcategories'));
    }

    public function create(): View
    {
        return $this->form(new TourSubcategory);
    }

    public function store(Request $request): RedirectResponse
    {
        $subcategory = new TourSubcategory;
        $this->persist($request, $subcategory);

        return redirect()->route('admin.tour-subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    public function edit(TourSubcategory $tourSubcategory): View
    {
        return $this->form($tourSubcategory);
    }

    public function update(Request $request, TourSubcategory $tourSubcategory): RedirectResponse
    {
        $this->persist($request, $tourSubcategory);

        return redirect()->route('admin.tour-subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(TourSubcategory $tourSubcategory): RedirectResponse
    {
        if ($tourSubcategory->tours()->exists()) {
            return back()->with('error', 'This subcategory has tours. Set it inactive instead of deleting it.');
        }
        if (is_string($tourSubcategory->image) && $tourSubcategory->image !== '') {
            Storage::disk('public')->delete($tourSubcategory->image);
        }
        $tourSubcategory->delete();

        return redirect()->route('admin.tour-subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }

    private function form(TourSubcategory $subcategory): View
    {
        return view('admin.tour-subcategories.form', ['subcategory' => $subcategory, 'categories' => TourCategory::query()->orderBy('display_order')->get()]);
    }

    private function persist(Request $request, TourSubcategory $subcategory): void
    {
        $data = $request->validate(['tour_category_id' => ['required', 'exists:tour_categories,id'], 'name' => ['required', 'string', 'max:120'], 'slug' => ['nullable', 'string', 'max:140', Rule::unique('tour_subcategories', 'slug')->ignore($subcategory)], 'description' => ['nullable', 'string'], 'image' => ['nullable', 'image', 'max:4096'], 'display_order' => ['nullable', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean'], 'meta_title' => ['nullable', 'string', 'max:255'], 'meta_description' => ['nullable', 'string', 'max:500']]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if (is_string($subcategory->image) && $subcategory->image !== '') {
                Storage::disk('public')->delete($subcategory->image);
            }

            $data['image'] = $request->file('image')->store('tour-subcategories', 'public');
        }
        $subcategory->fill($data)->save();
    }
}
