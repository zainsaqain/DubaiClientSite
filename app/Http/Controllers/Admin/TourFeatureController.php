<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourFeature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TourFeatureController extends Controller
{
    public function index(): View
    {
        return view('admin.tour-features.index', ['features' => TourFeature::query()->withCount('tours')->orderBy('name')->paginate(20)]);
    }

    public function store(Request $request): RedirectResponse
    {
        TourFeature::query()->create($request->validate(['name' => ['required', 'string', 'max:100', 'unique:tour_features,name'], 'icon' => ['nullable', 'string', 'max:50'], 'is_active' => ['nullable', 'boolean']]) + ['is_active' => $request->boolean('is_active')]);

        return back()->with('success', 'Feature created successfully.');
    }

    public function update(Request $request, TourFeature $tourFeature): RedirectResponse
    {
        $tourFeature->update($request->validate(['name' => ['required', 'string', 'max:100', Rule::unique('tour_features', 'name')->ignore($tourFeature)], 'icon' => ['nullable', 'string', 'max:50'], 'is_active' => ['nullable', 'boolean']]) + ['is_active' => $request->boolean('is_active')]);

        return back()->with('success', 'Feature updated successfully.');
    }

    public function destroy(TourFeature $tourFeature): RedirectResponse
    {
        if ($tourFeature->tours()->exists()) {
            return back()->with('error', 'This feature is in use. Set it inactive instead.');
        }
        $tourFeature->delete();

        return back()->with('success', 'Feature deleted successfully.');
    }
}
