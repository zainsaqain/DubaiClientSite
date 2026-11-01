<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaterparkThemePark;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WaterparkThemeParkController extends Controller
{
    public function index(): View
    {
        return view('admin.waterparks-theme-parks.index', [
            'parks' => WaterparkThemePark::query()->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.waterparks-theme-parks.form', ['park' => new WaterparkThemePark]);
    }

    public function store(Request $request): RedirectResponse
    {
        $park = new WaterparkThemePark;
        $this->savePark($request, $park);

        return redirect()->route('admin.waterparks-theme-parks.index')->with('success', 'Park experience created successfully.');
    }

    public function edit(WaterparkThemePark $waterparkThemePark): View
    {
        return view('admin.waterparks-theme-parks.form', ['park' => $waterparkThemePark]);
    }

    public function update(Request $request, WaterparkThemePark $waterparkThemePark): RedirectResponse
    {
        $this->savePark($request, $waterparkThemePark);

        return redirect()->route('admin.waterparks-theme-parks.index')->with('success', 'Park experience updated successfully.');
    }

    public function destroy(WaterparkThemePark $waterparkThemePark): RedirectResponse
    {
        if ($waterparkThemePark->image && ! str_starts_with($waterparkThemePark->image, 'images/')) {
            Storage::disk('public')->delete($waterparkThemePark->image);
        }

        $waterparkThemePark->delete();

        return redirect()->route('admin.waterparks-theme-parks.index')->with('success', 'Park experience removed successfully.');
    }

    private function savePark(Request $request, WaterparkThemePark $park): void
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'park_type' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:1200'],
            'location' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($park->image && ! str_starts_with($park->image, 'images/')) {
                Storage::disk('public')->delete($park->image);
            }

            $data['image'] = $request->file('image')->store('waterparks-theme-parks', 'public');
        }

        $park->fill($data)->save();
    }
}
