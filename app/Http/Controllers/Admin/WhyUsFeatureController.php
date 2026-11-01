<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyUsFeature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WhyUsFeatureController extends Controller
{
    public function index(): View
    {
        return view('admin.why-us.index', ['features' => WhyUsFeature::query()->orderBy('display_order')->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.why-us.form', ['feature' => new WhyUsFeature(['display_order' => (WhyUsFeature::max('display_order') ?? 0) + 1])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $feature = new WhyUsFeature;
        $this->saveFeature($request, $feature);

        return redirect()->route('admin.why-us.index')->with('success', 'Why Us section created successfully.');
    }

    public function edit(WhyUsFeature $whyUsFeature): View
    {
        return view('admin.why-us.form', ['feature' => $whyUsFeature]);
    }

    public function update(Request $request, WhyUsFeature $whyUsFeature): RedirectResponse
    {
        $this->saveFeature($request, $whyUsFeature);

        return redirect()->route('admin.why-us.index')->with('success', 'Why Us section updated successfully.');
    }

    public function destroy(WhyUsFeature $whyUsFeature): RedirectResponse
    {
        if ($whyUsFeature->image && ! str_starts_with($whyUsFeature->image, 'images/')) {
            Storage::disk('public')->delete($whyUsFeature->image);
        }

        $whyUsFeature->delete();

        return redirect()->route('admin.why-us.index')->with('success', 'Why Us section removed successfully.');
    }

    private function saveFeature(Request $request, WhyUsFeature $feature): void
    {
        $data = $request->validate([
            'eyebrow' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:1800'],
            'link_label' => ['nullable', 'string', 'max:100'],
            'link_url' => ['nullable', 'string', 'max:255'],
            'display_order' => ['required', 'integer', 'min:1', 'max:999'],
            'image' => ['nullable', 'image', 'max:4096'],
            'is_reversed' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_reversed'] = $request->boolean('is_reversed');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($feature->image && ! str_starts_with($feature->image, 'images/')) {
                Storage::disk('public')->delete($feature->image);
            }

            $data['image'] = $request->file('image')->store('why-us', 'public');
        }

        $feature->fill($data)->save();
    }
}
