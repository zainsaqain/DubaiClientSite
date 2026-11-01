<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        return view('admin.home.hero.index', ['slides' => HeroSlide::query()->orderBy('display_order')->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.home.hero.form', ['slide' => new HeroSlide(['display_order' => (HeroSlide::max('display_order') ?? 0) + 1])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $slide = new HeroSlide;
        $this->saveSlide($request, $slide);

        return redirect()->route('admin.home.hero.index')->with('success', 'Hero slide created successfully.');
    }

    public function edit(HeroSlide $hero): View
    {
        return view('admin.home.hero.form', ['slide' => $hero]);
    }

    public function update(Request $request, HeroSlide $hero): RedirectResponse
    {
        $this->saveSlide($request, $hero);

        return redirect()->route('admin.home.hero.index')->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HeroSlide $hero): RedirectResponse
    {
        if ($hero->image && ! str_starts_with($hero->image, 'images/')) {
            Storage::disk('public')->delete($hero->image);
        }

        $hero->delete();

        return redirect()->route('admin.home.hero.index')->with('success', 'Hero slide removed successfully.');
    }

    private function saveSlide(Request $request, HeroSlide $slide): void
    {
        $data = $request->validate([
            'badge' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:180'],
            'heading_highlight' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:500'],
            'image_alt' => ['nullable', 'string', 'max:200'],
            'primary_label' => ['required', 'string', 'max:60'],
            'primary_url' => ['required', 'string', 'max:255'],
            'secondary_label' => ['required', 'string', 'max:60'],
            'secondary_url' => ['required', 'string', 'max:255'],
            'feature_one' => ['required', 'string', 'max:60'],
            'feature_two' => ['required', 'string', 'max:60'],
            'feature_three' => ['required', 'string', 'max:60'],
            'display_order' => ['required', 'integer', 'min:1', 'max:999'],
            'image' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($slide->image && ! str_starts_with($slide->image, 'images/')) {
                Storage::disk('public')->delete($slide->image);
            }

            $data['image'] = $request->file('image')->store('hero-slides', 'public');
        }

        $slide->fill($data)->save();
    }
}
