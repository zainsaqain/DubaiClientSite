<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourCategory;
use App\Models\TourCategoryFaq;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TourCategoryFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.category-faqs.index', [
            'faqs' => TourCategoryFaq::query()
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
        return view('admin.category-faqs.form', [
            'faq' => new TourCategoryFaq(['is_active' => true]),
            'categories' => $this->categories(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $faq = new TourCategoryFaq;
        $this->persist($request, $faq);

        return redirect()->route('admin.category-faqs.index')->with('success', 'Category FAQ created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(TourCategoryFaq $categoryFaq): View
    {
        return view('admin.category-faqs.form', [
            'faq' => $categoryFaq,
            'categories' => $this->categories(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourCategoryFaq $categoryFaq): RedirectResponse
    {
        $this->persist($request, $categoryFaq);

        return redirect()->route('admin.category-faqs.index')->with('success', 'Category FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourCategoryFaq $categoryFaq): RedirectResponse
    {
        $categoryFaq->delete();

        return redirect()->route('admin.category-faqs.index')->with('success', 'Category FAQ removed successfully.');
    }

    /** @return Collection<int, TourCategory> */
    private function categories(): Collection
    {
        return TourCategory::query()->orderBy('display_order')->orderBy('name')->get(['id', 'name']);
    }

    private function persist(Request $request, TourCategoryFaq $faq): void
    {
        $data = $request->validate([
            'tour_category_id' => ['required', 'integer', Rule::exists('tour_categories', 'id')],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'display_order' => ['required', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $faq->fill($data)->save();
    }
}
