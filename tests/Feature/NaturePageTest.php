<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NaturePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_nature_page_shows_only_the_configured_nature_tours_and_is_linked_from_why_us(): void
    {
        $desertCategory = TourCategory::query()->create([
            'name' => 'Desert Adventures',
            'slug' => 'desert-adventures',
            'is_active' => true,
        ]);
        $cityCategory = TourCategory::query()->create([
            'name' => 'City Tours',
            'slug' => 'city-tours',
            'is_active' => true,
        ]);
        Tour::query()->create([
            'tour_category_id' => $desertCategory->id,
            'name' => 'Evening Desert Safari in Dubai',
            'slug' => 'evening-desert-safari-in-dubai',
            'location' => 'Dubai',
            'starting_price' => 49937,
            'currency' => 'PKR',
            'status' => 'active',
        ]);
        Tour::query()->create([
            'tour_category_id' => $cityCategory->id,
            'name' => 'Private Al Ain City Tour',
            'slug' => 'private-al-ain-city-tour',
            'location' => 'Al Ain',
            'starting_price' => 60000,
            'currency' => 'PKR',
            'status' => 'active',
        ]);
        Tour::query()->create([
            'tour_category_id' => $desertCategory->id,
            'name' => 'Unrelated Desert Tour',
            'slug' => 'unrelated-desert-tour',
            'location' => 'Dubai',
            'starting_price' => 1000,
            'currency' => 'PKR',
            'status' => 'active',
        ]);

        $this->get(route('nature'))
            ->assertOk()
            ->assertSee('Nature')
            ->assertSee('Evening Desert Safari in Dubai')
            ->assertSee('Private Al Ain City Tour')
            ->assertDontSee('Unrelated Desert Tour')
            ->assertSee('Al Ain (1)')
            ->assertSee('Dubai (1)');

        $this->get(route('why-us'))
            ->assertOk()
            ->assertSee(route('nature'), false);
    }
}
