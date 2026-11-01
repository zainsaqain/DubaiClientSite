<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CruiseBoatTour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CruiseBoatTourController extends Controller
{
    public function index(): View
    {
        return view('admin.cruise-boat-tours.index', [
            'tours' => CruiseBoatTour::query()->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.cruise-boat-tours.form', [
            'tour' => new CruiseBoatTour,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tour = new CruiseBoatTour;
        $this->saveTour($request, $tour);

        return redirect()->route('admin.cruise-boat-tours.index')->with('success', 'Cruise or boat tour created successfully.');
    }

    public function edit(CruiseBoatTour $cruiseBoatTour): View
    {
        return view('admin.cruise-boat-tours.form', [
            'tour' => $cruiseBoatTour,
        ]);
    }

    public function update(Request $request, CruiseBoatTour $cruiseBoatTour): RedirectResponse
    {
        $this->saveTour($request, $cruiseBoatTour);

        return redirect()->route('admin.cruise-boat-tours.index')->with('success', 'Cruise or boat tour updated successfully.');
    }

    public function destroy(CruiseBoatTour $cruiseBoatTour): RedirectResponse
    {
        if ($cruiseBoatTour->image && ! str_starts_with($cruiseBoatTour->image, 'images/')) {
            Storage::disk('public')->delete($cruiseBoatTour->image);
        }

        $cruiseBoatTour->delete();

        return redirect()->route('admin.cruise-boat-tours.index')->with('success', 'Cruise or boat tour removed successfully.');
    }

    private function saveTour(Request $request, CruiseBoatTour $tour): void
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'tour_type' => ['required', 'string', 'max:80'],
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
            if ($tour->image && ! str_starts_with($tour->image, 'images/')) {
                Storage::disk('public')->delete($tour->image);
            }

            $data['image'] = $request->file('image')->store('cruise-boat-tours', 'public');
        }

        $tour->fill($data)->save();
    }
}
