<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CityTour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CityTourController extends Controller
{
    public function index(): View
    {
        return view('admin.city-tours.index', ['tours' => CityTour::query()->latest()->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.city-tours.form', ['tour' => new CityTour]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tour = new CityTour;
        $this->saveTour($request, $tour);

        return redirect()->route('admin.city-tours.index')->with('success', 'City tour created successfully.');
    }

    public function edit(CityTour $cityTour): View
    {
        return view('admin.city-tours.form', ['tour' => $cityTour]);
    }

    public function update(Request $request, CityTour $cityTour): RedirectResponse
    {
        $this->saveTour($request, $cityTour);

        return redirect()->route('admin.city-tours.index')->with('success', 'City tour updated successfully.');
    }

    public function destroy(CityTour $cityTour): RedirectResponse
    {
        if ($cityTour->image && ! str_starts_with($cityTour->image, 'images/')) {
            Storage::disk('public')->delete($cityTour->image);
        } $cityTour->delete();

        return redirect()->route('admin.city-tours.index')->with('success', 'City tour removed successfully.');
    }

    private function saveTour(Request $request, CityTour $tour): void
    {
        $data = $request->validate(['title' => ['required', 'string', 'max:160'], 'tour_type' => ['required', 'string', 'max:80'], 'description' => ['required', 'string', 'max:1200'], 'location' => ['required', 'string', 'max:100'], 'price' => ['required', 'numeric', 'min:0'], 'image' => ['nullable', 'image', 'max:4096'], 'is_featured' => ['nullable', 'boolean'], 'is_active' => ['nullable', 'boolean']]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($tour->image && ! str_starts_with($tour->image, 'images/')) {
                Storage::disk('public')->delete($tour->image);
            } $data['image'] = $request->file('image')->store('city-tours', 'public');
        }
        $tour->fill($data)->save();
    }
}
