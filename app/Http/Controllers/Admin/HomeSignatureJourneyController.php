<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSignatureJourney;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeSignatureJourneyController extends Controller
{
    public function index(): View
    {
        return view('admin.home.signature-journeys.index', ['journeys' => HomeSignatureJourney::query()->orderBy('display_order')->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.home.signature-journeys.form', ['journey' => new HomeSignatureJourney(['display_order' => (HomeSignatureJourney::max('display_order') ?? 0) + 1])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $journey = new HomeSignatureJourney;
        $this->saveJourney($request, $journey);

        return redirect()->route('admin.home.signature-journeys.index')->with('success', 'Signature Journey created successfully.');
    }

    public function edit(HomeSignatureJourney $signatureJourney): View
    {
        return view('admin.home.signature-journeys.form', ['journey' => $signatureJourney]);
    }

    public function update(Request $request, HomeSignatureJourney $signatureJourney): RedirectResponse
    {
        $this->saveJourney($request, $signatureJourney);

        return redirect()->route('admin.home.signature-journeys.index')->with('success', 'Signature Journey updated successfully.');
    }

    public function destroy(HomeSignatureJourney $signatureJourney): RedirectResponse
    {
        if ($signatureJourney->image && ! str_starts_with($signatureJourney->image, 'images/')) {
            Storage::disk('public')->delete($signatureJourney->image);
        }
        $signatureJourney->delete();

        return redirect()->route('admin.home.signature-journeys.index')->with('success', 'Signature Journey removed successfully.');
    }

    private function saveJourney(Request $request, HomeSignatureJourney $journey): void
    {
        $data = $request->validate([
            'badge' => ['required', 'string', 'max:60'], 'caption' => ['required', 'string', 'max:120'],
            'eyebrow' => ['required', 'string', 'max:100'], 'title' => ['required', 'string', 'max:160'], 'highlight' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:800'], 'point_one' => ['required', 'string', 'max:100'], 'point_two' => ['required', 'string', 'max:100'], 'point_three' => ['required', 'string', 'max:100'],
            'button_label' => ['required', 'string', 'max:80'], 'button_url' => ['required', 'string', 'max:255'], 'display_order' => ['required', 'integer', 'min:1', 'max:999'],
            'image' => ['nullable', 'image', 'max:5120'], 'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($journey->image && ! str_starts_with($journey->image, 'images/')) {
                Storage::disk('public')->delete($journey->image);
            }
            $data['image'] = $request->file('image')->store('home-signature-journeys', 'public');
        }
        $journey->fill($data)->save();
    }
}
