<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeTestimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeTestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.home.testimonials.index', ['testimonials' => HomeTestimonial::query()->orderBy('display_order')->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.home.testimonials.form', ['testimonial' => new HomeTestimonial(['rating' => 5, 'display_order' => (HomeTestimonial::max('display_order') ?? 0) + 1])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $testimonial = new HomeTestimonial;
        $this->saveTestimonial($request, $testimonial);

        return redirect()->route('admin.home.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(HomeTestimonial $testimonial): View
    {
        return view('admin.home.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, HomeTestimonial $testimonial): RedirectResponse
    {
        $this->saveTestimonial($request, $testimonial);

        return redirect()->route('admin.home.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(HomeTestimonial $testimonial): RedirectResponse
    {
        if ($testimonial->avatar && ! str_starts_with($testimonial->avatar, 'images/')) {
            Storage::disk('public')->delete($testimonial->avatar);
        }
        $testimonial->delete();

        return redirect()->route('admin.home.testimonials.index')->with('success', 'Testimonial removed successfully.');
    }

    private function saveTestimonial(Request $request, HomeTestimonial $testimonial): void
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'], 'country' => ['required', 'string', 'max:100'],
            'quote' => ['required', 'string', 'max:1200'], 'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'display_order' => ['required', 'integer', 'min:1', 'max:999'], 'avatar' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'], 'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar && ! str_starts_with($testimonial->avatar, 'images/')) {
                Storage::disk('public')->delete($testimonial->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('home-testimonials', 'public');
        }
        $testimonial->fill($data)->save();
    }
}
