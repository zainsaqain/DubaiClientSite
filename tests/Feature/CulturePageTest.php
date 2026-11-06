<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourSubcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CulturePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_culture_page_reuses_the_city_tours_catalogue_and_is_linked_from_why_us(): void
    {
        $category = TourCategory::query()->create([
            'name' => 'City Tours',
            'slug' => 'city-tours',
            'is_active' => true,
        ]);
        $subcategory = TourSubcategory::query()->create([
            'tour_category_id' => $category->id,
            'name' => 'Culture & Heritage',
            'slug' => 'culture-heritage',
            'is_active' => true,
        ]);
        Tour::query()->create([
            'tour_category_id' => $category->id,
            'tour_subcategory_id' => $subcategory->id,
            'name' => 'Private Abu Dhabi City Tour',
            'slug' => 'private-abu-dhabi-city-tour',
            'short_description' => 'A cultural city experience.',
            'location' => 'Abu Dhabi',
            'starting_price' => 25000,
            'currency' => 'PKR',
            'status' => 'active',
        ]);

        $this->get(route('culture'))
            ->assertOk()
            ->assertSee('Culture')
            ->assertSee('Why us')
            ->assertSee('Private Abu Dhabi City Tour')
            ->assertSee('Abu Dhabi (1)')
            ->assertSee('data-filter="category"', false);

        $this->get(route('why-us'))
            ->assertOk()
            ->assertSee(route('culture'), false);
    }
}
