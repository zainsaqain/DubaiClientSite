<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesertAdventure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DesertAdventureController extends Controller
{
    public function index(): View
    {
        return view('admin.desert-adventures.index', [
            'adventures' => DesertAdventure::query()->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.desert-adventures.form', [
            'adventure' => new DesertAdventure,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $adventure = new DesertAdventure;
        $this->saveAdventure($request, $adventure);

        return redirect()->route('admin.desert-adventures.index')->with('success', 'Desert adventure created successfully.');
    }

    public function edit(DesertAdventure $desertAdventure): View
    {
        return view('admin.desert-adventures.form', [
            'adventure' => $desertAdventure,
        ]);
    }

    public function update(Request $request, DesertAdventure $desertAdventure): RedirectResponse
    {
        $this->saveAdventure($request, $desertAdventure);

        return redirect()->route('admin.desert-adventures.index')->with('success', 'Desert adventure updated successfully.');
    }

    public function destroy(DesertAdventure $desertAdventure): RedirectResponse
    {
        if ($desertAdventure->image) {
            Storage::disk('public')->delete($desertAdventure->image);
        }

        $desertAdventure->delete();

        return redirect()->route('admin.desert-adventures.index')->with('success', 'Desert adventure removed successfully.');
    }

    private function saveAdventure(Request $request, DesertAdventure $adventure): void
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'category' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:1200'],
            'location' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:80'],
            'image' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($adventure->image) {
                Storage::disk('public')->delete($adventure->image);
            }

            $data['image'] = $request->file('image')->store('desert-adventures', 'public');
        }

        $adventure->fill($data)->save();
    }
}
