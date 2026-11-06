<?php

namespace Tests\Feature;

use App\Models\Attraction;
use App\Models\DesertAdventure;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourSubcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogueSourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_attractions_catalogue_displays_only_active_public_tour_records(): void
    {
        $category = TourCategory::query()->create([
            'name' => 'Attractions',
            'slug' => 'attractions',
            'is_active' => true,
        ]);
        $subcategory = TourSubcategory::query()->create([
            'tour_category_id' => $category->id,
            'name' => 'Entry Tickets',
            'slug' => 'entry-tickets',
            'is_active' => true,
        ]);
        Tour::query()->create([
            'tour_category_id' => $category->id,
            'tour_subcategory_id' => $subcategory->id,
            'name' => 'Database Attraction',
            'slug' => 'database-attraction',
            'location' => 'Dubai',
            'starting_price' => 5000,
            'currency' => 'PKR',
            'status' => 'active',
        ]);
        Attraction::query()->create([
            'title' => 'Legacy-only Attraction',
            'attraction_type' => 'Entry Tickets',
            'description' => 'This record is not a unified tour.',
            'location' => 'Dubai',
            'price' => 3000,
            'is_active' => true,
        ]);

        $this->get(route('attractions'))
            ->assertOk()
            ->assertSee('Database Attraction')
            ->assertDontSee('Legacy-only Attraction');
    }

    public function test_desert_subcategory_catalogues_do_not_fall_back_to_legacy_or_configured_records(): void
    {
        $category = TourCategory::query()->create([
            'name' => 'Desert Adventures',
            'slug' => 'desert-adventures',
            'is_active' => true,
        ]);
        $subcategory = TourSubcategory::query()->create([
            'tour_category_id' => $category->id,
            'name' => 'Dune Buggies',
            'slug' => 'dune-buggies',
            'is_active' => true,
        ]);
        Tour::query()->create([
            'tour_category_id' => $category->id,
            'tour_subcategory_id' => $subcategory->id,
            'name' => 'Database Dune Buggy Tour',
            'slug' => 'database-dune-buggy-tour',
            'location' => 'Dubai',
            'starting_price' => 12000,
            'currency' => 'PKR',
            'status' => 'active',
        ]);
        DesertAdventure::query()->create([
            'title' => 'Legacy-only Dune Buggy Tour',
            'category' => 'Dune Buggies',
            'description' => 'This record is not a unified tour.',
            'location' => 'Dubai',
            'price' => 9000,
            'is_active' => true,
        ]);

        $this->get(route('dune-buggies-category'))
            ->assertOk()
            ->assertSee('Database Dune Buggy Tour')
            ->assertDontSee('Legacy-only Dune Buggy Tour');
    }
}
