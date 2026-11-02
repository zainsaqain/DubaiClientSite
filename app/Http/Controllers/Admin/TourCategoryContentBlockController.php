<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourCategory;
use App\Models\TourCategoryContentBlock;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TourCategoryContentBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.category-content-blocks.index', [
            'blocks' => TourCategoryContentBlock::query()
                ->with('category:id,name')
                ->orderBy('tour_category_id')
                ->orderBy('display_order')
                ->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.category-content-blocks.form', [
            'block' => new TourCategoryContentBlock(['is_active' => true]),
            'categories' => $this->categories(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $block = new TourCategoryContentBlock;
        $this->persist($request, $block);

        return redirect()->route('admin.category-content-blocks.index')->with('success', 'Category story block created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(TourCategoryContentBlock $categoryContentBlock): View
    {
        return view('admin.category-content-blocks.form', [
            'block' => $categoryContentBlock,
            'categories' => $this->categories(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourCategoryContentBlock $categoryContentBlock): RedirectResponse
    {
        $this->persist($request, $categoryContentBlock);

        return redirect()->route('admin.category-content-blocks.index')->with('success', 'Category story block updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourCategoryContentBlock $categoryContentBlock): RedirectResponse
    {
        if ($categoryContentBlock->image && ! str_starts_with($categoryContentBlock->image, 'images/')) {
            Storage::disk('public')->delete($categoryContentBlock->image);
        }

        $categoryContentBlock->delete();

        return redirect()->route('admin.category-content-blocks.index')->with('success', 'Category story block removed successfully.');
    }

    /** @return Collection<int, TourCategory> */
    private function categories(): Collection
    {
        return TourCategory::query()->orderBy('display_order')->orderBy('name')->get(['id', 'name']);
    }

    private function persist(Request $request, TourCategoryContentBlock $block): void
    {
        $data = $request->validate([
            'tour_category_id' => ['required', 'integer', Rule::exists('tour_categories', 'id')],
            'heading' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'layout' => ['required', Rule::in(['image_left', 'image_right'])],
            'display_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($block->image && ! str_starts_with($block->image, 'images/')) {
                Storage::disk('public')->delete($block->image);
            }

            $data['image'] = $request->file('image')->store('category-content-blocks', 'public');
        }

        $block->fill($data)->save();
    }
}
