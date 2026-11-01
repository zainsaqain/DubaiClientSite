<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\HomePromoCard;
use App\Models\HomeSignatureJourney;
use App\Models\HomeTestimonial;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourSubcategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PublicCatalogueController extends Controller
{
    public function home(): View
    {
        $tours = Tour::query()
            ->public()
            ->with(['category', 'subcategory', 'images'])
            ->orderByDesc('is_featured')
            ->orderBy('display_order')
            ->get();

        $desertTours = $tours
            ->filter(fn (Tour $tour): bool => $tour->category?->slug === 'desert-adventures')
            ->take(6);
        $featuredTours = $tours->where('is_featured', true);

        return view('welcome', [
            'heroSlides' => HeroSlide::query()
                ->where('is_active', true)
                ->orderBy('display_order')
                ->get()
                ->map(fn (HeroSlide $slide): array => $slide->toHeroArray())
                ->all(),
            'desertSafarisList' => $desertTours->map(fn (Tour $tour): array => $this->homeTourCard($tour))->all(),
            'experienceCategories' => TourCategory::query()
                ->where('is_active', true)
                ->whereHas('tours', fn (Builder $query): Builder => $query->public())
                ->with(['tours' => fn ($query) => $query->public()->orderBy('display_order')->limit(1)])
                ->orderBy('display_order')
                ->get()
                ->map(function (TourCategory $category): array {
                    $representativeTour = $category->tours->first();

                    return [
                        'title' => $category->name,
                        'description' => $category->description,
                        'image' => $representativeTour?->imageUrl(),
                        'url' => route('tour-categories.show', $category),
                    ];
                })
                ->all(),
            'trendingAttractionsList' => ($featuredTours->isNotEmpty() ? $featuredTours : $tours)
                ->take(6)
                ->map(fn (Tour $tour): array => $this->homeTourCard($tour))
                ->all(),
            'cityTourPromos' => HomePromoCard::query()
                ->where('is_active', true)
                ->orderBy('display_order')
                ->get()
                ->map(fn (HomePromoCard $card): array => $card->toPromoArray())
                ->all(),
            'topCityToursList' => $tours
                ->filter(fn (Tour $tour): bool => $tour->category?->slug === 'city-tours')
                ->take(6)
                ->map(fn (Tour $tour): array => $this->homeTourCard($tour))
                ->all(),
            'signatureJourneys' => HomeSignatureJourney::query()
                ->where('is_active', true)
                ->orderBy('display_order')
                ->get(),
            'testimonials' => HomeTestimonial::query()
                ->where('is_active', true)
                ->orderBy('display_order')
                ->get(),
            'dubaiMoments' => $tours
                ->take(5)
                ->values()
                ->map(fn (Tour $tour, int $index): array => [
                    'title' => $tour->name,
                    'label' => $tour->subcategory?->name ?? $tour->category?->name,
                    'image' => $tour->imageUrl(),
                    'url' => route('tours.show', $tour),
                    'class' => ['moment-featured', 'moment-tall', 'moment-regular', 'moment-regular', 'moment-wide'][$index] ?? 'moment-regular',
                ])
                ->all(),
        ]);
    }

    public function category(Request $request, TourCategory $category): View
    {
        abort_unless($category->is_active, 404);

        $subcategories = $category->subcategories()
            ->where('is_active', true)
            ->whereHas('tours', fn (Builder $query): Builder => $query->public())
            ->orderBy('display_order')
            ->get();

        return $this->catalogue(
            $request,
            Tour::query()->public()->where('tour_category_id', $category->id),
            $category,
            null,
            $subcategories,
        );
    }

    public function subcategory(Request $request, TourCategory $category, TourSubcategory $subcategory): View
    {
        abort_unless(
            $category->is_active
            && $subcategory->is_active
            && $subcategory->tour_category_id === $category->id,
            404,
        );

        return $this->catalogue(
            $request,
            Tour::query()
                ->public()
                ->where('tour_category_id', $category->id)
                ->where('tour_subcategory_id', $subcategory->id),
            $category,
            $subcategory,
            collect(),
        );
    }

    public function search(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:120'],
            'subcategory' => ['nullable', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:120'],
            'sort' => ['nullable', Rule::in(['featured', 'price_asc', 'price_desc', 'name'])],
        ]);

        $query = Tour::query()->public();

        if ($searchTerm = trim((string) ($filters['q'] ?? ''))) {
            $query->where(function (Builder $tourQuery) use ($searchTerm): void {
                $tourQuery
                    ->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('location', 'like', "%{$searchTerm}%")
                    ->orWhereHas('category', fn (Builder $categoryQuery): Builder => $categoryQuery
                        ->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('slug', 'like', "%{$searchTerm}%"))
                    ->orWhereHas('subcategory', fn (Builder $subcategoryQuery): Builder => $subcategoryQuery
                        ->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('slug', 'like', "%{$searchTerm}%"));
            });
        }

        if ($category = $filters['category'] ?? null) {
            $query->whereHas('category', fn (Builder $categoryQuery): Builder => $categoryQuery
                ->where('slug', $category)
                ->orWhere('name', 'like', "%{$category}%"));
        }

        if ($subcategory = $filters['subcategory'] ?? null) {
            $query->whereHas('subcategory', fn (Builder $subcategoryQuery): Builder => $subcategoryQuery
                ->where('slug', $subcategory)
                ->orWhere('name', 'like', "%{$subcategory}%"));
        }

        if ($location = $filters['location'] ?? null) {
            $query->where('location', 'like', "%{$location}%");
        }

        return $this->catalogue($request, $query, null, null, collect(), $filters);
    }

    /**
     * @param  Builder<Tour>  $query
     * @param  Collection<int, TourSubcategory>  $subcategories
     * @param  array<string, string>  $filters
     */
    private function catalogue(
        Request $request,
        Builder $query,
        ?TourCategory $category,
        ?TourSubcategory $subcategory,
        Collection $subcategories,
        array $filters = [],
    ): View {
        $sort = $filters['sort'] ?? $request->input('sort', 'featured');
        $searchTerm = trim((string) $request->input('q'));
        $pageTitle = $subcategory?->name ?? $category?->name ?? 'Search Dubai Experiences';
        $pageDescription = $subcategory?->meta_description
            ?: $category?->meta_description
            ?: $subcategory?->description
            ?: $category?->description
            ?: 'Search active Dubai experiences by activity, category, location, or subcategory.';

        if ($searchTerm && ! array_key_exists('q', $filters)) {
            $query->where(function (Builder $tourQuery) use ($searchTerm): void {
                $tourQuery
                    ->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('location', 'like', "%{$searchTerm}%");
            });
        }

        $tours = $this->applySort($query, $sort)
            ->with(['category', 'subcategory', 'images'])
            ->paginate(12)
            ->withQueryString();

        return view('pages.tour-catalogue', compact(
            'category',
            'filters',
            'pageDescription',
            'pageTitle',
            'sort',
            'subcategory',
            'subcategories',
            'tours',
        ));
    }

    /** @param Builder<Tour> $query */
    private function applySort(Builder $query, string $sort): Builder
    {
        return match ($sort) {
            'price_asc' => $query->orderBy('starting_price'),
            'price_desc' => $query->orderByDesc('starting_price'),
            'name' => $query->orderBy('name'),
            default => $query->orderByDesc('is_featured')->orderBy('display_order')->orderByDesc('id'),
        };
    }

    /** @return array<string, mixed> */
    private function homeTourCard(Tour $tour): array
    {
        return [
            'badge' => $tour->is_bestseller ? 'Bestseller' : ($tour->is_original ? 'Original' : ($tour->subcategory?->name ?? $tour->category?->name)),
            'bestseller' => $tour->is_bestseller,
            'category' => $tour->subcategory?->name ?? $tour->category?->name,
            'image' => $tour->imageUrl(),
            'location' => $tour->location,
            'price' => $tour->currency.' '.number_format((float) $tour->starting_price),
            'title' => $tour->name,
            'travellers_choice' => $tour->is_travellers_choice,
            'url' => route('tours.show', $tour),
        ];
    }
}
