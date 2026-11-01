<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourImage;
use App\Models\TourPackage;
use App\Models\TourPrice;
use App\Models\TourSubcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_category_and_subcategory_pages_only_render_eligible_tours(): void
    {
        $category = $this->createCategory('desert-adventures', 'Desert Adventures');
        $subcategory = $this->createSubcategory($category, 'desert-safaris', 'Desert Safaris');
        $visibleTour = $this->createTour($category, $subcategory, 'visible-safari', 'Visible Safari');
        $inactiveTour = $this->createTour($category, $subcategory, 'hidden-safari', 'Hidden Safari', ['status' => 'inactive']);

        $this->get(route('tour-categories.show', $category))
            ->assertOk()
            ->assertSee($visibleTour->name)
            ->assertDontSee($inactiveTour->name)
            ->assertSee('Desert Adventures');

        $this->get(route('tour-subcategories.show', [$category, $subcategory]))
            ->assertOk()
            ->assertSee($visibleTour->name)
            ->assertDontSee($inactiveTour->name);

        $inactiveCategory = $this->createCategory('inactive-collection', 'Inactive Collection', false);
        $this->get(route('tour-categories.show', $inactiveCategory))->assertNotFound();
    }

    public function test_subcategory_must_belong_to_requested_category(): void
    {
        $desertCategory = $this->createCategory('desert-adventures', 'Desert Adventures');
        $cityCategory = $this->createCategory('city-tours', 'City Tours');
        $citySubcategory = $this->createSubcategory($cityCategory, 'dubai-city', 'Dubai City');

        $this->get(route('tour-subcategories.show', [$desertCategory, $citySubcategory]))->assertNotFound();
    }

    public function test_search_filters_active_tours_and_preserves_sorting_and_query_string(): void
    {
        $category = $this->createCategory('attractions', 'Attractions');
        $subcategory = $this->createSubcategory($category, 'skyline-views', 'Skyline Views');
        $lowPrice = $this->createTour($category, $subcategory, 'skyline-low', 'Skyline Low', ['starting_price' => 90]);
        $highPrice = $this->createTour($category, $subcategory, 'skyline-high', 'Skyline High', ['starting_price' => 250]);
        $this->createTour($category, $subcategory, 'hidden-skyline', 'Hidden Skyline', ['status' => 'inactive']);

        $this->get(route('tours.search', [
            'q' => 'Skyline',
            'location' => 'Dubai',
            'sort' => 'price_asc',
        ]))
            ->assertOk()
            ->assertSeeInOrder([$lowPrice->name, $highPrice->name])
            ->assertDontSee('Hidden Skyline')
            ->assertSee('value="Skyline"', false);
    }

    public function test_tour_detail_uses_dynamic_breadcrumbs_images_and_package_prices(): void
    {
        $category = $this->createCategory('desert-adventures', 'Desert Adventures');
        $subcategory = $this->createSubcategory($category, 'desert-safaris', 'Desert Safaris');
        $tour = $this->createTour($category, $subcategory, 'evening-safari', 'Evening Safari', [
            'meta_title' => 'Evening Safari in Dubai',
            'meta_description' => 'A database-backed desert safari.',
            'main_image' => 'images/desert-safari.png',
        ]);
        TourImage::query()->create(['tour_id' => $tour->id, 'path' => 'images/desert-camp-experience.png', 'alt' => 'Camp', 'display_order' => 1]);
        $package = TourPackage::query()->create(['tour_id' => $tour->id, 'name' => 'Private Safari', 'is_active' => true]);
        TourPrice::query()->create(['tour_id' => $tour->id, 'tour_package_id' => $package->id, 'vehicle_type' => 'private', 'adult_price' => 475, 'currency' => 'AED', 'is_active' => true]);

        $this->get(route('tours.show', $tour))
            ->assertOk()
            ->assertSee('Evening Safari in Dubai')
            ->assertSee('A database-backed desert safari.', false)
            ->assertSee(route('tour-categories.show', $category), false)
            ->assertSee(route('tour-subcategories.show', [$category, $subcategory]), false)
            ->assertSee('Private Safari')
            ->assertSee('AED 475')
            ->assertSee('images/desert-camp-experience.png');
    }

    public function test_homepage_catalogue_cards_are_loaded_from_active_tours(): void
    {
        $category = $this->createCategory('desert-adventures', 'Desert Adventures');
        $subcategory = $this->createSubcategory($category, 'desert-safaris', 'Desert Safaris');
        $visibleTour = $this->createTour($category, $subcategory, 'database-safari', 'Database Safari');
        $this->createTour($category, $subcategory, 'inactive-home-safari', 'Inactive Home Safari', ['status' => 'inactive']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($visibleTour->name)
            ->assertDontSee('Inactive Home Safari')
            ->assertSee(route('tours.show', $visibleTour), false);
    }

    public function test_category_listing_paginates_active_tours(): void
    {
        $category = $this->createCategory('city-tours', 'City Tours');
        $subcategory = $this->createSubcategory($category, 'dubai-city', 'Dubai City');

        foreach (range(1, 13) as $number) {
            $this->createTour($category, $subcategory, "city-tour-{$number}", "City Tour {$number}");
        }

        $this->get(route('tour-categories.show', $category).'?page=2')
            ->assertOk()
            ->assertSee('City Tour 1')
            ->assertSee('Page 2 of 2');
    }

    private function createCategory(string $slug, string $name, bool $isActive = true): TourCategory
    {
        return TourCategory::query()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => $name.' description.',
            'is_active' => $isActive,
        ]);
    }

    private function createSubcategory(TourCategory $category, string $slug, string $name): TourSubcategory
    {
        return TourSubcategory::query()->create([
            'tour_category_id' => $category->id,
            'name' => $name,
            'slug' => $slug,
            'description' => $name.' description.',
            'is_active' => true,
        ]);
    }

    /** @param array<string, mixed> $overrides */
    private function createTour(TourCategory $category, TourSubcategory $subcategory, string $slug, string $name, array $overrides = []): Tour
    {
        return Tour::query()->create(array_merge([
            'tour_category_id' => $category->id,
            'tour_subcategory_id' => $subcategory->id,
            'name' => $name,
            'slug' => $slug,
            'short_description' => $name.' description.',
            'location' => 'Dubai',
            'starting_price' => 150,
            'currency' => 'AED',
            'status' => 'active',
            'thumbnail' => 'images/desert-safari.png',
        ], $overrides));
    }
}
