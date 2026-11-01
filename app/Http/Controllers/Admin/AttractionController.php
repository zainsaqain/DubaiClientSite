<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AttractionController extends Controller
{
    public function index(): View
    {
        return view('admin.attractions.index', ['attractions' => Attraction::query()->latest()->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.attractions.form', ['attraction' => new Attraction]);
    }

    public function store(Request $request): RedirectResponse
    {
        $attraction = new Attraction;
        $this->saveAttraction($request, $attraction);

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction created successfully.');
    }

    public function edit(Attraction $attraction): View
    {
        return view('admin.attractions.form', compact('attraction'));
    }

    public function update(Request $request, Attraction $attraction): RedirectResponse
    {
        $this->saveAttraction($request, $attraction);

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction updated successfully.');
    }

    public function destroy(Attraction $attraction): RedirectResponse
    {
        if ($attraction->image && ! str_starts_with($attraction->image, 'images/')) {
            Storage::disk('public')->delete($attraction->image);
        }
        $attraction->delete();

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction removed successfully.');
    }

    private function saveAttraction(Request $request, Attraction $attraction): void
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'], 'attraction_type' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:1200'], 'location' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'], 'image' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'], 'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($attraction->image && ! str_starts_with($attraction->image, 'images/')) {
                Storage::disk('public')->delete($attraction->image);
            }
            $data['image'] = $request->file('image')->store('attractions', 'public');
        }
        $attraction->fill($data)->save();
    }
}
