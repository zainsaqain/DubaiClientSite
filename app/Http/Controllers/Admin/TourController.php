<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourFeature;
use App\Models\TourSubcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TourController extends Controller
{
    public function index(Request $request): View
    {
        $tours = Tour::query()
            ->with(['category', 'subcategory'])
            ->when($request->filled('search'), function ($query) use ($request): void {
                $query->where('name', 'like', '%'.$request->string('search').'%');
            })
            ->when($request->filled('category'), function ($query) use ($request): void {
                $query->where('tour_category_id', $request->integer('category'));
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status'));
            })
            ->orderBy('display_order')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.tours.index', [
            'tours' => $tours,
            'categories' => TourCategory::query()->orderBy('display_order')->get(),
        ]);
    }

    public function create(): View
    {
        return $this->form(new Tour);
    }

    public function store(Request $request): RedirectResponse
    {
        $tour = new Tour;
        $this->persist($request, $tour);

        return redirect()->route('admin.tours.index')->with('success', 'Tour created and saved to the catalogue.');
    }

    public function show(Tour $tour): View
    {
        $tour->load(['category', 'subcategory', 'images', 'features', 'itineraries', 'packages.prices', 'prices.package', 'availabilities']);

        return view('admin.tours.show', compact('tour'));
    }

    public function edit(Tour $tour): View
    {
        $tour->load(['images', 'features', 'itineraries', 'packages.prices', 'prices', 'availabilities']);

        return $this->form($tour);
    }

    public function update(Request $request, Tour $tour): RedirectResponse
    {
        $this->persist($request, $tour);

        return redirect()->route('admin.tours.index')->with('success', 'Tour updated successfully.');
    }

    public function destroy(Tour $tour): RedirectResponse
    {
        DB::transaction(function () use ($tour): void {
            foreach ($tour->images as $image) {
                Storage::disk('public')->delete($image->path);
            }
            Storage::disk('public')->delete(array_filter([$tour->thumbnail, $tour->main_image]));
            $tour->delete();
        });

        return redirect()->route('admin.tours.index')->with('success', 'Tour removed successfully.');
    }

    public function subcategories(Request $request): JsonResponse
    {
        $request->validate(['category_id' => ['required', 'integer', 'exists:tour_categories,id']]);

        return response()->json(TourSubcategory::query()
            ->where('tour_category_id', $request->integer('category_id'))
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get(['id', 'name']));
    }

    private function form(Tour $tour): View
    {
        return view('admin.tours.form', [
            'tour' => $tour,
            'categories' => TourCategory::query()->where('is_active', true)->orderBy('display_order')->get(),
            'subcategories' => $tour->tour_category_id
                ? TourSubcategory::query()->where('tour_category_id', $tour->tour_category_id)->orderBy('display_order')->get()
                : collect(),
            'features' => TourFeature::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    private function removeEmptyPriceRows(Request $request): void
    {
        $prices = [];

        foreach ($request->input('prices', []) as $price) {
            if (! is_array($price) || ! $this->containsPriceDetails($price)) {
                continue;
            }

            $prices[] = $price;
        }

        $request->merge(['prices' => $prices]);
    }

    /**
     * @param  array<string, mixed>  $price
     */
    private function containsPriceDetails(array $price): bool
    {
        foreach ([
            'package_index',
            'vehicle_label',
            'description',
            'adult_price',
            'child_price',
            'child_min_age',
            'child_max_age',
            'infant_price',
            'infant_max_age',
            'maximum_guests',
        ] as $field) {
            if (filled($price[$field] ?? null)) {
                return true;
            }
        }

        return false;
    }

    private function persist(Request $request, Tour $tour): void
    {
        $this->removeEmptyPriceRows($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:190', Rule::unique('tours', 'slug')->ignore($tour)],
            'tour_category_id' => ['required', 'exists:tour_categories,id'],
            'tour_subcategory_id' => ['nullable', 'exists:tour_subcategories,id'],
            'short_description' => ['nullable', 'string', 'max:1200'],
            'location' => ['required', 'string', 'max:120'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'duration_unit' => ['nullable', 'in:minutes,hours,days'],
            'experience_time' => ['nullable', 'in:morning,evening,anytime'],
            'languages' => ['nullable', 'array'],
            'languages.*' => ['string', 'max:40'],
            'starting_price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:8'],
            'status' => ['required', 'in:active,inactive,draft'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'gallery' => ['nullable', 'array'], 'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gallery_alt' => ['nullable', 'array'], 'gallery_caption' => ['nullable', 'array'],
            'remove_image_ids' => ['nullable', 'array'], 'remove_image_ids.*' => ['integer'],
            'feature_status' => ['nullable', 'array'], 'feature_status.*' => ['nullable', 'in:included,optional,not_included'],
            'about' => ['nullable', 'string'], 'full_description' => ['nullable', 'string'], 'pickup_information' => ['nullable', 'string'],
            'itineraries' => ['nullable', 'array'], 'itineraries.*.title' => ['nullable', 'string', 'max:180'], 'itineraries.*.description' => ['nullable', 'string'], 'itineraries.*.duration' => ['nullable', 'integer', 'min:1'], 'itineraries.*.duration_unit' => ['nullable', 'in:minutes,hours,days'], 'itineraries.*.icon' => ['nullable', 'string', 'max:40'],
            'highlights' => ['nullable', 'string'], 'know_before_you_go' => ['nullable', 'string'], 'age_policy' => ['nullable', 'string'], 'cancellation_policy' => ['nullable', 'string'], 'additional_notes' => ['nullable', 'string'],
            'packages' => ['nullable', 'array'], 'packages.*.name' => ['nullable', 'string', 'max:120'], 'packages.*.description' => ['nullable', 'string'], 'packages.*.is_active' => ['nullable', 'boolean'], 'packages.*.is_recommended' => ['nullable', 'boolean'], 'packages.*.badge_label' => ['nullable', 'string', 'max:80'],
            'prices' => ['nullable', 'array'], 'prices.*.package_index' => ['nullable', 'integer', 'min:0'], 'prices.*.vehicle_type' => ['required_with:prices', 'in:shared,private'], 'prices.*.vehicle_label' => ['nullable', 'string', 'max:120'], 'prices.*.description' => ['nullable', 'string'], 'prices.*.adult_price' => ['required_with:prices', 'numeric', 'min:0'], 'prices.*.child_price' => ['nullable', 'numeric', 'min:0'], 'prices.*.child_min_age' => ['nullable', 'integer', 'min:0', 'max:99'], 'prices.*.child_max_age' => ['nullable', 'integer', 'min:0', 'max:99'], 'prices.*.infant_price' => ['nullable', 'numeric', 'min:0'], 'prices.*.infant_max_age' => ['nullable', 'integer', 'min:0', 'max:99'], 'prices.*.minimum_guests' => ['nullable', 'integer', 'min:1'], 'prices.*.maximum_guests' => ['nullable', 'integer', 'min:1'],
            'availabilities' => ['nullable', 'array'], 'availabilities.*.available_date' => ['nullable', 'date'], 'availabilities.*.start_time' => ['nullable', 'date_format:H:i'], 'availabilities.*.capacity' => ['nullable', 'integer', 'min:1'], 'availabilities.*.booking_cutoff_hours' => ['nullable', 'integer', 'min:0'], 'availabilities.*.is_blocked' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'], 'meta_description' => ['nullable', 'string', 'max:500'],
            'is_featured' => ['nullable', 'boolean'], 'is_bestseller' => ['nullable', 'boolean'], 'is_travellers_choice' => ['nullable', 'boolean'], 'is_original' => ['nullable', 'boolean'], 'location_badge' => ['nullable', 'string', 'max:80'], 'promotion_label' => ['nullable', 'string', 'max:100'], 'display_order' => ['nullable', 'integer', 'min:0'], 'youtube_url' => ['nullable', 'url', 'max:255'],
        ]);

        if ($data['tour_subcategory_id'] ?? null) {
            $matchesCategory = TourSubcategory::query()->whereKey($data['tour_subcategory_id'])->where('tour_category_id', $data['tour_category_id'])->exists();
            if (! $matchesCategory) {
                abort(422, 'The selected subcategory does not belong to the selected category.');
            }
        }

        DB::transaction(function () use ($request, $tour, $data): void {
            $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['name']);
            $data['languages'] = array_values(array_filter($data['languages'] ?? []));
            foreach (['is_featured', 'is_bestseller', 'is_travellers_choice', 'is_original'] as $flag) {
                $data[$flag] = $request->boolean($flag);
            }
            foreach (['thumbnail', 'main_image', 'gallery', 'gallery_alt', 'gallery_caption', 'remove_image_ids', 'feature_status', 'itineraries', 'packages', 'prices', 'availabilities'] as $field) {
                unset($data[$field]);
            }
            if ($request->hasFile('thumbnail')) {
                if ($tour->thumbnail) {
                    Storage::disk('public')->delete($tour->thumbnail);
                }
                $data['thumbnail'] = $request->file('thumbnail')->store('tours/thumbnails', 'public');
            }
            if ($request->hasFile('main_image')) {
                if ($tour->main_image) {
                    Storage::disk('public')->delete($tour->main_image);
                }
                $data['main_image'] = $request->file('main_image')->store('tours/main', 'public');
            }
            $tour->fill($data)->save();
            foreach ($tour->images()->whereIn('id', $request->input('remove_image_ids', []))->get() as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
            foreach ($request->file('gallery', []) as $index => $galleryImage) {
                $tour->images()->create(['path' => $galleryImage->store('tours/gallery', 'public'), 'alt' => $request->input("gallery_alt.$index"), 'caption' => $request->input("gallery_caption.$index"), 'display_order' => $index]);
            }
            $featureRows = [];
            foreach ($request->input('feature_status', []) as $featureId => $inclusionStatus) {
                if (in_array($inclusionStatus, ['included', 'optional', 'not_included'], true)) {
                    $featureRows[$featureId] = ['inclusion_status' => $inclusionStatus];
                }
            }
            $tour->features()->sync($featureRows);
            $tour->itineraries()->delete();
            foreach (array_values($request->input('itineraries', [])) as $index => $item) {
                if (! empty($item['title'])) {
                    $tour->itineraries()->create([...$item, 'display_order' => $index + 1]);
                }
            }
            $tour->prices()->delete();
            $tour->packages()->delete();
            $packages = [];
            foreach (array_values($request->input('packages', [])) as $index => $package) {
                if (! empty($package['name'])) {
                    $packages[$index] = $tour->packages()->create(['name' => $package['name'], 'description' => $package['description'] ?? null, 'is_active' => (bool) ($package['is_active'] ?? true), 'is_recommended' => (bool) ($package['is_recommended'] ?? false), 'badge_label' => $package['badge_label'] ?? null, 'display_order' => $index + 1]);
                }
            }
            foreach ($request->input('prices', []) as $price) {
                if (isset($price['adult_price'], $price['vehicle_type'])) {
                    $max = $price['maximum_guests'] ?? null;
                    if ($max && $max < ($price['minimum_guests'] ?? 1)) {
                        abort(422, 'Maximum guests cannot be lower than minimum guests.');
                    } $tour->prices()->create(['tour_package_id' => isset($price['package_index']) ? ($packages[$price['package_index']]->id ?? null) : null, 'vehicle_type' => $price['vehicle_type'], 'vehicle_label' => $price['vehicle_label'] ?? null, 'description' => $price['description'] ?? null, 'adult_price' => $price['adult_price'], 'child_price' => $price['child_price'] ?? null, 'child_min_age' => $price['child_min_age'] ?? null, 'child_max_age' => $price['child_max_age'] ?? null, 'infant_price' => $price['infant_price'] ?? null, 'infant_max_age' => $price['infant_max_age'] ?? null, 'minimum_guests' => $price['minimum_guests'] ?? 1, 'maximum_guests' => $max, 'currency' => $tour->currency, 'is_active' => true]);
                }
            }
            $tour->availabilities()->delete();
            foreach ($request->input('availabilities', []) as $availability) {
                if (! empty($availability['available_date']) || ! empty($availability['start_time'])) {
                    $tour->availabilities()->create(['available_date' => $availability['available_date'] ?: null, 'start_time' => $availability['start_time'] ?: null, 'capacity' => $availability['capacity'] ?: null, 'booking_cutoff_hours' => $availability['booking_cutoff_hours'] ?? 0, 'is_blocked' => (bool) ($availability['is_blocked'] ?? false)]);
                }
            }
        });
    }
}
