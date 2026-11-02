<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourCategoryContentBlock;
use App\Models\TourCategoryFaq;
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
        $category = $this->createCategory('attractions', 'Attractions');
        $subcategory = $this->createSubcategory($category, 'city-sightseeing', 'City Sightseeing');
        $visibleTour = $this->createTour($category, $subcategory, 'visible-safari', 'Visible Safari');
        $inactiveTour = $this->createTour($category, $subcategory, 'hidden-safari', 'Hidden Safari', ['status' => 'inactive']);

        $this->get(route('tour-categories.show', $category))
            ->assertOk()
            ->assertSee($visibleTour->name)
            ->assertDontSee($inactiveTour->name)
            ->assertSee('Attractions');

        $this->get(route('tour-subcategories.show', [$category, $subcategory]))
            ->assertOk()
            ->assertSee($visibleTour->name)
            ->assertDontSee($inactiveTour->name);

        $inactiveCategory = $this->createCategory('inactive-collection', 'Inactive Collection', false);
        $this->get(route('tour-categories.show', $inactiveCategory))->assertNotFound();
    }

    public function test_desert_adventures_only_lists_active_tours_from_its_active_subcategories(): void
    {
        $desertCategory = $this->createCategory('desert-adventures', 'Desert Adventures');
        $safaris = $this->createSubcategory($desertCategory, 'desert-safaris', 'Desert Safaris');
        $buggies = $this->createSubcategory($desertCategory, 'dune-buggies', 'Dune Buggies');
        $cityCategory = $this->createCategory('city-tours', 'City Tours');
        $citySubcategory = $this->createSubcategory($cityCategory, 'city-sightseeing', 'City Sightseeing');

        $firstSafari = $this->createTour($desertCategory, $safaris, 'sunset-safari', 'Sunset Safari');
        $secondSafari = $this->createTour($desertCategory, $safaris, 'morning-safari', 'Morning Safari');
        $buggyTour = $this->createTour($desertCategory, $buggies, 'dune-buggy', 'Dune Buggy');
        $this->createTour($desertCategory, $safaris, 'inactive-safari', 'Inactive Safari', ['status' => 'inactive']);
        $this->createTour($cityCategory, $citySubcategory, 'city-tour', 'City Tour');
        $this->createTour($desertCategory, $citySubcategory, 'invalid-assignment', 'Invalid Assignment');

        $this->get(route('desert-adventures'))
            ->assertOk()
            ->assertSee($firstSafari->name)
            ->assertSee($secondSafari->name)
            ->assertSee($buggyTour->name)
            ->assertSee('Desert Safaris (2)')
            ->assertSee('Dune Buggies (1)')
            ->assertSee('value="desert-safaris"', false)
            ->assertDontSee('data-title="inactive safari"', false)
            ->assertDontSee('data-title="city tour"', false)
            ->assertDontSee('data-title="invalid assignment"', false);
    }

    public function test_subcategory_must_belong_to_requested_category(): void
    {
        $desertCategory = $this->createCategory('desert-adventures', 'Desert Adventures');
        $cityCategory = $this->createCategory('city-tours', 'City Tours');
        $citySubcategory = $this->createSubcategory($cityCategory, 'dubai-city', 'Dubai City');

        $this->get(route('tour-subcategories.show', [$desertCategory, $citySubcategory]))->assertNotFound();
    }

    public function test_direct_category_and_subcategory_urls_render_the_database_catalogue(): void
    {
        $category = $this->createCategory('boat-experiences', 'Boat Experiences');
        $subcategory = $this->createSubcategory($category, 'morning-safaris', 'Morning Safaris');
        $tour = $this->createTour($category, $subcategory, 'sunrise-safari', 'Sunrise Safari');

        $this->get(route('catalogue.shortcut', ['catalogueSlug' => $category->slug]))
            ->assertOk()
            ->assertSee($category->name)
            ->assertSee($tour->name);

        $this->get(route('catalogue.shortcut', ['catalogueSlug' => $subcategory->slug]))
            ->assertOk()
            ->assertSee($subcategory->name)
            ->assertSee($tour->name);
    }

    public function test_direct_desert_safaris_url_redirects_to_the_desert_safaris_page(): void
    {
        $category = $this->createCategory('desert-adventures', 'Desert Adventures');
        $subcategory = $this->createSubcategory($category, 'desert-safaris', 'Desert Safaris');

        $this->get(route('catalogue.shortcut', ['catalogueSlug' => $subcategory->slug]))
            ->assertStatus(301)
            ->assertRedirect(url('/desert-adventures/desert-safaris'));
    }

    public function test_desert_safaris_page_only_lists_active_tours_from_the_matching_category_and_subcategory(): void
    {
        $desertCategory = $this->createCategory('desert-adventures', 'Desert Adventures');
        $safaris = $this->createSubcategory($desertCategory, 'desert-safaris', 'Desert Safaris');
        $buggies = $this->createSubcategory($desertCategory, 'dune-buggies', 'Dune Buggies');
        $cityCategory = $this->createCategory('city-tours', 'City Tours');
        $citySubcategory = $this->createSubcategory($cityCategory, 'city-sightseeing', 'City Sightseeing');

        $matchingTour = $this->createTour($desertCategory, $safaris, 'evening-safari', 'Evening Safari');
        $otherSubcategoryTour = $this->createTour($desertCategory, $buggies, 'dune-buggy', 'Dune Buggy');
        $otherCategoryTour = $this->createTour($cityCategory, $citySubcategory, 'city-tour', 'City Tour');
        $inactiveTour = $this->createTour($desertCategory, $safaris, 'inactive-safari', 'Inactive Safari', ['status' => 'inactive']);

        $this->get(route('desert-safaris'))
            ->assertOk()
            ->assertSee($matchingTour->name)
            ->assertDontSee('data-title="'.str($otherSubcategoryTour->name)->lower().'"', false)
            ->assertDontSee('data-title="'.str($otherCategoryTour->name)->lower().'"', false)
            ->assertDontSee('data-title="'.str($inactiveTour->name)->lower().'"', false);
    }

    public function test_abu_dhabi_city_tours_page_only_lists_active_abu_dhabi_tours(): void
    {
        $cityTours = $this->createCategory('city-tours', 'City Tours');
        $abuDhabi = $this->createSubcategory($cityTours, 'abu-dhabi', 'Abu Dhabi');
        $alAin = $this->createSubcategory($cityTours, 'al-ain', 'Al Ain');

        $abuDhabiTour = $this->createTour($cityTours, $abuDhabi, 'abu-dhabi-city-tour', 'Abu Dhabi City Tour');
        $alAinTour = $this->createTour($cityTours, $alAin, 'al-ain-city-tour', 'Al Ain City Tour');
        $inactiveTour = $this->createTour($cityTours, $abuDhabi, 'inactive-abu-dhabi-tour', 'Inactive Abu Dhabi Tour', ['status' => 'inactive']);

        $this->get(route('city-tours.destination', $abuDhabi))
            ->assertOk()
            ->assertSee('Abu Dhabi City Tours')
            ->assertSee('data-tour-card-id="'.$abuDhabiTour->id.'"', false)
            ->assertDontSee('data-tour-card-id="'.$alAinTour->id.'"', false)
            ->assertDontSee('data-tour-card-id="'.$inactiveTour->id.'"', false);
    }

    public function test_city_tours_page_renders_its_category_content_destinations_and_faqs(): void
    {
        $cityTours = $this->createCategory('city-tours', 'City Tours');
        $abuDhabi = $this->createSubcategory($cityTours, 'abu-dhabi', 'Abu Dhabi');
        $cityTour = $this->createTour($cityTours, $abuDhabi, 'abu-dhabi-city-tour', 'Abu Dhabi City Tour');

        TourCategoryContentBlock::query()->create([
            'tour_category_id' => $cityTours->id,
            'heading' => 'Explore every city with confidence',
            'body' => 'Practical content managed for the City Tours category.',
            'display_order' => 1,
            'is_active' => true,
        ]);

        TourCategoryFaq::query()->create([
            'tour_category_id' => $cityTours->id,
            'question' => 'Can I explore Abu Dhabi on a city tour?',
            'answer' => 'Check the selected tour for its current itinerary and options.',
            'display_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('city-tours'))
            ->assertOk()
            ->assertSee($cityTour->name)
            ->assertSee('Explore every city with confidence')
            ->assertSee('Can I explore Abu Dhabi on a city tour?')
            ->assertSee(route('city-tours.destination', $abuDhabi), false);
    }

    public function test_generic_desert_category_urls_redirect_to_the_canonical_desert_urls(): void
    {
        $category = $this->createCategory('desert-adventures', 'Desert Adventures');
        $subcategory = $this->createSubcategory($category, 'desert-safaris', 'Desert Safaris');
        $this->createTour($category, $subcategory, 'desert-safari', 'Desert Safari');

        $this->get(route('tour-categories.show', $category))
            ->assertStatus(301)
            ->assertRedirect(route('desert-adventures'));

        $this->get(route('tour-subcategories.show', [$category, $subcategory]))
            ->assertStatus(301)
            ->assertRedirect(url('/desert-adventures/desert-safaris'));
    }

    public function test_legacy_city_tour_urls_redirect_to_the_canonical_city_tour_urls(): void
    {
        $category = $this->createCategory('city-tours', 'City Tours');
        $subcategory = $this->createSubcategory($category, 'abu-dhabi', 'Abu Dhabi');

        $this->get(route('tour-categories.show', $category))
            ->assertStatus(301)
            ->assertRedirect(route('city-tours'));

        $this->get(route('tour-subcategories.show', [$category, $subcategory]))
            ->assertStatus(301)
            ->assertRedirect(route('city-tours.destination', $subcategory));
    }

    public function test_each_city_tours_subcategory_uses_the_shared_destination_page(): void
    {
        $category = $this->createCategory('city-tours', 'City Tours');
        $sharjah = $this->createSubcategory($category, 'sharjah', 'Sharjah');
        $abuDhabi = $this->createSubcategory($category, 'abu-dhabi', 'Abu Dhabi');
        $sharjahTour = $this->createTour($category, $sharjah, 'sharjah-city-tour', 'Sharjah City Tour');
        $abuDhabiTour = $this->createTour($category, $abuDhabi, 'abu-dhabi-city-tour', 'Abu Dhabi City Tour');

        $this->get(route('city-tours.destination', $sharjah))
            ->assertOk()
            ->assertSee('Sharjah City Tours')
            ->assertSee('data-tour-card-id="'.$sharjahTour->id.'"', false)
            ->assertDontSee('data-tour-card-id="'.$abuDhabiTour->id.'"', false);
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
        $relatedTour = $this->createTour($category, $subcategory, 'morning-safari', 'Morning Safari');

        $this->get(route('tours.show', $tour))
            ->assertOk()
            ->assertSee('Evening Safari in Dubai')
            ->assertSee('A database-backed desert safari.', false)
            ->assertSee(route('desert-adventures'), false)
            ->assertSee(url('/desert-adventures/desert-safaris'), false)
            ->assertSee('Private Safari')
            ->assertSee('AED 475')
            ->assertSee('images/desert-camp-experience.png')
            ->assertSee($relatedTour->name)
            ->assertSee('Other experiences you might like')
            ->assertSee('Recently viewed')
            ->assertSee('data-traveler-picker', false)
            ->assertSee('data-booking-service-choice', false);
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

    public function test_shared_header_lists_active_categories_and_subcategories_before_tours_are_added(): void
    {
        $category = $this->createCategory('cruise-and-boat-tours', 'Cruise and Boat Tours');
        $subcategory = $this->createSubcategory($category, 'marina-cruises', 'Marina Cruises');
        $cityTours = $this->createCategory('city-tours', 'City Tours');
        $abuDhabi = $this->createSubcategory($cityTours, 'abu-dhabi', 'Abu Dhabi');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($category->name)
            ->assertSee($subcategory->name)
            ->assertSee(route('tour-subcategories.show', [$category, $subcategory]), false)
            ->assertSee($cityTours->name)
            ->assertSee($abuDhabi->name)
            ->assertSee(route('city-tours.destination', $abuDhabi), false);
    }

    public function test_category_listing_paginates_active_tours(): void
    {
        $category = $this->createCategory('attractions', 'Attractions');
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
