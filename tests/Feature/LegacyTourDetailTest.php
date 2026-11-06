<?php

namespace Tests\Feature;

use App\Models\Attraction;
use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegacyTourDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_record_fallback_detail_page_is_available_when_it_has_not_been_migrated(): void
    {
        $attraction = Attraction::query()->create([
            'title' => 'Historic City Landmark',
            'attraction_type' => 'Entry Tickets',
            'description' => 'A landmark experience.',
            'location' => 'Dubai',
            'price' => 5000,
            'image' => 'images/dubai-attractions.png',
            'is_active' => true,
        ]);

        $this->get(route('legacy-tours.show', ['type' => 'attraction', 'legacyTour' => $attraction]))
            ->assertOk()
            ->assertSee('Historic City Landmark')
            ->assertSee('A landmark experience.');
    }

    public function test_legacy_catalogue_card_redirects_to_the_full_managed_tour_detail_when_available(): void
    {
        $attraction = Attraction::query()->create([
            'title' => 'Managed City Landmark',
            'attraction_type' => 'Entry Tickets',
            'description' => 'A managed landmark experience.',
            'location' => 'Dubai',
            'price' => 5000,
            'image' => 'images/dubai-attractions.png',
            'is_active' => true,
        ]);
        $category = TourCategory::query()->create([
            'name' => 'Attractions',
            'slug' => 'attractions',
            'is_active' => true,
        ]);
        $tour = Tour::query()->create([
            'tour_category_id' => $category->id,
            'name' => 'Managed City Landmark',
            'slug' => 'managed-city-landmark',
            'location' => 'Dubai',
            'starting_price' => 5000,
            'currency' => 'PKR',
            'status' => 'active',
        ]);

        $this->get(route('legacy-tours.show', ['type' => 'attraction', 'legacyTour' => $attraction]))
            ->assertRedirect(route('tours.show', $tour));
    }
}
